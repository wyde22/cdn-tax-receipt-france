<?php

use CRM_Cdntaxreceiptsfr_ExtensionUtil as E;

class CRM_Cdntaxreceiptsfr_Form_Report_ReceiptsIssued extends CRM_Report_Form {

  function __construct() {

    $this->_customGroupExtends = array('Contact', 'Individual', 'Organization');
    $this->_autoIncludeIndexedFieldsAsOrderBys = TRUE;

    $this->_columns = array(
      'civicrm_contact' =>
      array(
        'dao' => 'CRM_Contact_DAO_Contact',
        'fields' =>
        array(
          'sort_name' =>
          array('title' => E::ts('Contact Name (Current Value)'),
            'required' => TRUE,
          ),
          'id' =>
          array(
            'no_display' => TRUE,
            'required' => TRUE,
            'type' => CRM_Utils_Type::T_INT,
          ),
        ),
        'grouping' => 'tax-fields',
        'order_bys' =>
        array(
          'sort_name' =>
          array(
            'title' => ts('Last Name, First Name', array('domain' => DOMAINS_CDNTAX_FR)),
          ),
        ),
      ),
      'civicrm_cdntaxreceiptsfr_log' =>
      array(
        'dao' => 'CRM_Contribute_DAO_Contribution',
        'fields' =>
        array(
          'issued_on' => array('title' => 'Issued On', 'default' => TRUE,'type' => CRM_Utils_Type::T_TIMESTAMP,),
          'receipt_amount' => array('title' => 'Receipt Amount', 'default' => TRUE, 'type' => CRM_Utils_Type::T_MONEY,),
          'receipt_no' => array('title' => 'Receipt No.', 'default' => TRUE),
          'issue_type' => array('title' => 'Issue Type', 'default' => TRUE),
          'issue_method' => array('title' => 'Issue Method', 'default' => TRUE),
          'uid' => array('title' => 'Issued By', 'default' => TRUE, 'type' => CRM_Utils_Type::T_INT),
          'receipt_status' => array('title' => 'Receipt Status', 'default' => TRUE,),
          'email_opened' => array('title' => 'Email Open Date', 'type' => CRM_Utils_Type::T_TIMESTAMP, 'default' => TRUE),
        ),
        'grouping' => 'tax-fields',
        'filters' =>
        array(
          'issued_on' =>
          array(
            'title' => 'Issued On',
            'type' => CRM_Utils_Type::T_TIMESTAMP,
            'operatorType' => CRM_Report_Form::OP_DATE),
          'issue_type' =>
            array(
              'title' => ts('Issue Type'),
              'operatorType' => CRM_Report_Form::OP_MULTISELECT,
              'options' => array('single' => ts('Single'), 'annual' => ts('Annual'), 'aggregate' => ts('Aggregate')),
              'type' => CRM_Utils_Type::T_STRING,
            ),
          'issue_method' =>
            array(
            'title' => ts('Issue Method', array('domain' => DOMAINS_CDNTAX_FR)),
            'operatorType' => CRM_Report_Form::OP_MULTISELECT,
            'options' => array('email' => 'Email', 'print' => 'Print'),
            'type' => CRM_Utils_Type::T_STRING,
          ),
          'receipt_status' =>
            array(
              'title' => ts('Receipt Status', array('domain' => DOMAINS_CDNTAX_FR)),
              'operatorType' => CRM_Report_Form::OP_MULTISELECT,
              'options' => array('issued' => 'Issued', 'cancelled' => 'Cancelled'),
              'type' => CRM_Utils_Type::T_STRING,
            ),
          'email_opened' =>
          array('title' => ts('Email Open Date', array('domain' => DOMAINS_CDNTAX_FR)),
            'type' => CRM_Utils_Type::T_DATE,
            'operatorType' => CRM_Report_Form::OP_DATE,
          ),
        ),
        'order_bys' =>
        array(
          'issued_on' =>
            array(
              'title' => 'Issued On', 'default' => '1', 'default_weight' => '0', 'default_order' => 'DESC',
            ),
          'receipt_no' =>
            array(
              'title' => ts('Receipt No.', array('domain' => DOMAINS_CDNTAX_FR)),
            ),
          'receipt_amount' =>
            array(
              'title' => ts('Receipt Amount', array('domain' => DOMAINS_CDNTAX_FR)),
            ),
          'receipt_status' =>
            array(
              'title' => ts('Receipt Status', array('domain' => DOMAINS_CDNTAX_FR)),
            ),
        ),
      ),
      'civicrm_cdntaxreceiptsfr_log_contributions' =>
      array(
        'dao' => 'CRM_Contribute_DAO_Contribution',
        'fields' =>
        array(
          'contribution_id' => array(
            'default' => TRUE,
            'dbAlias' => "GROUP_CONCAT(DISTINCT cdntaxreceiptsfr_log_contributions_civireport.contribution_id ORDER BY cdntaxreceiptsfr_log_contributions_civireport.contribution_id SEPARATOR ', ')",
            'type' => CRM_Utils_Type::T_INT,
           ),
        ),
        'grouping' => 'tax-fields',
      ),
      'civicrm_line_item' => array(
        'dao' => 'CRM_Price_DAO_LineItem',
        'fields' => array(
          'financial_type_id' => array(
            'title' => E::ts('Financial Type (current value)'),
            'default' => FALSE,
            'type' => CRM_Utils_Type::T_STRING,
            // look up words in alterDisplay
            'dbAlias' => "GROUP_CONCAT(DISTINCT line_item_civireport.financial_type_id ORDER BY line_item_civireport.contribution_id, line_item_civireport.financial_type_id SEPARATOR ',')",
          ),
        ),
        'filters' => array(),
        'grouping' => 'tax-fields',
      ),
      'civicrm_contribution' => array(
        'dao' => 'CRM_Contribute_DAO_Contribution',
        'fields' => array(
          'payment_instrument_id' => array(
            'title' => E::ts('Payment Method (current value)'),
            'default' => FALSE,
            'type' => CRM_Utils_Type::T_STRING,
            // look up words in alterDisplay
            'dbAlias' => "GROUP_CONCAT(DISTINCT contribution_civireport.payment_instrument_id ORDER BY contribution_civireport.id, contribution_civireport.payment_instrument_id SEPARATOR ',')",
          ),
        ),
        'filters' => array(
          /* The problem with this is you then need to join on this table
           * in the statistics section and it messes up the grouping because
           * it's only expecting one table involved.
           *
          'payment_instrument_id' => array(
            'title' => E::ts('Payment Method (current value)'),
            'operatorType' => CRM_Report_Form::OP_MULTISELECT,
            'options' => CRM_Contribute_BAO_Contribution::buildOptions('payment_instrument_id', 'get'),
            'type' => CRM_Utils_Type::T_INT,
          ),
           */
        ),
        'grouping' => 'tax-fields',
      ),
    );

    parent::__construct();
  }

  function preProcess() {
    parent::preProcess();

    //check for permission to edit contributions
    if ( ! CRM_Core_Permission::check('access CiviContribute') ) {
      CRM_Core_Error::fatal(ts('You do not have permission to access this page', array('domain' => DOMAINS_CDNTAX_FR)));
    }
  }

  function select() {
    $select = array();
    $this->_columnHeaders = array();
    foreach ($this->_columns as $tableName => $table) {
      if (array_key_exists('fields', $table)) {
        foreach ($table['fields'] as $fieldName => $field) {
          if (CRM_Utils_Array::value('required', $field) ||
            CRM_Utils_Array::value($fieldName, $this->_params['fields'])
          ) {
            $alias = "{$tableName}_{$fieldName}";
            $select[] = "{$field['dbAlias']} as {$alias}";
            $this->_columnHeaders["{$tableName}_{$fieldName}"]['type'] = CRM_Utils_Array::value('type', $field);
            $this->_columnHeaders["{$tableName}_{$fieldName}"]['title'] = $field['title'];
            $this->_selectAliases[] = $alias;
          }
        }
      }
    }

    $this->_select = "SELECT " . implode(', ', $select) . " ";
  }

  static
  function formRule($fields, $files, $self) {
    $errors = $grouping = array();
    return $errors;
  }

  function from() {
    $this->_from = "
        FROM cdntaxreceiptsfr_log {$this->_aliases['civicrm_cdntaxreceiptsfr_log']}
        INNER JOIN cdntaxreceiptsfr_log_contributions {$this->_aliases['civicrm_cdntaxreceiptsfr_log_contributions']}
                ON {$this->_aliases['civicrm_cdntaxreceiptsfr_log']}.id = {$this->_aliases['civicrm_cdntaxreceiptsfr_log_contributions']}.receipt_id
        LEFT  JOIN civicrm_contact {$this->_aliases['civicrm_contact']}
                ON {$this->_aliases['civicrm_contact']}.id = {$this->_aliases['civicrm_cdntaxreceiptsfr_log']}.contact_id
        LEFT  JOIN civicrm_contribution {$this->_aliases['civicrm_contribution']}
                ON {$this->_aliases['civicrm_contribution']}.id = {$this->_aliases['civicrm_cdntaxreceiptsfr_log_contributions']}.contribution_id
        LEFT  JOIN civicrm_line_item {$this->_aliases['civicrm_line_item']}
                ON {$this->_aliases['civicrm_line_item']}.contribution_id = {$this->_aliases['civicrm_cdntaxreceiptsfr_log_contributions']}.contribution_id";
  }

  function where() {
    $whereClauses = $havingClauses = array();
    foreach ($this->_columns as $tableName => $table) {
      if (array_key_exists('filters', $table)) {
        foreach ($table['filters'] as $fieldName => $field) {
          $clause = NULL;
          if (CRM_Utils_Array::value('type', $field) & (CRM_Utils_Type::T_DATE | CRM_Utils_Type::T_TIMESTAMP)) {
            if (CRM_Utils_Array::value('operatorType', $field) == CRM_Report_Form::OP_MONTH) {
              $op = CRM_Utils_Array::value("{$fieldName}_op", $this->_params);
              $value = CRM_Utils_Array::value("{$fieldName}_value", $this->_params);
              if (is_array($value) && !empty($value)) {
                $clause = "(month({$field['dbAlias']}) $op (" . implode(', ', $value) . '))';
              }
            }
            else {
              $relative = CRM_Utils_Array::value("{$fieldName}_relative", $this->_params);
              $from     = CRM_Utils_Array::value("{$fieldName}_from", $this->_params);
              $to       = CRM_Utils_Array::value("{$fieldName}_to", $this->_params);
              $fromTime = CRM_Utils_Array::value("{$fieldName}_from_time", $this->_params);
              $toTime   = CRM_Utils_Array::value("{$fieldName}_to_time", $this->_params);
              $clause   = $this->dateClause($field['dbAlias'], $relative, $from, $to, $field['type'], $fromTime, $toTime);
            }
          }
          else {
            $op = CRM_Utils_Array::value("{$fieldName}_op", $this->_params);
            if ($op) {
              $clause = $this->whereClause($field,
                $op,
                CRM_Utils_Array::value("{$fieldName}_value", $this->_params),
                CRM_Utils_Array::value("{$fieldName}_min", $this->_params),
                CRM_Utils_Array::value("{$fieldName}_max", $this->_params)
              );
            }
          }

          if (!empty($clause)) {
            if (CRM_Utils_Array::value('having', $field)) {
              $havingClauses[] = $clause;
            }
            else {
              $whereClauses[] = $clause;
            }
          }
        }
      }
    }

    if (empty($whereClauses)) {
      $this->_where = "WHERE ( 1 ) ";
      $this->_having = "";
    }
    else {
      $this->_where = "WHERE " . implode(' AND ', $whereClauses);
    }

    if ($this->_aclWhere) {
      $this->_where .= " AND {$this->_aclWhere} ";
    }

    if (!empty($havingClauses)) {
      // use this clause to construct group by clause.
      $this->_having = "HAVING " . implode(' AND ', $havingClauses);
    }
    $this->_where .= " AND {$this->_aliases['civicrm_cdntaxreceiptsfr_log']}.is_duplicate = 0 ";
  }

  function dateClause($fieldName,
                      $relative, $from, $to, $type = NULL, $fromTime = NULL, $toTime = NULL
  ) {
    $clauses = array();
    if (in_array($relative, array_keys(self::getOperationPair(CRM_Report_FORM::OP_DATE)))) {
      $sqlOP = self::getSQLOperator($relative);
      return "( {$fieldName} {$sqlOP} )";
    }

    list($from, $to) = self::getFromTo($relative, $from, $to, $fromTime, $toTime);

    if ($from) {
      $from = ($type == CRM_Utils_Type::T_DATE) ? substr($from, 0, 8) : $from;
      if ($type == CRM_Utils_Type::T_TIMESTAMP) {
        $time_array = date_parse_from_format ('YmdHis' ,  $from);
        $from = mktime($time_array['hour'], $time_array['minute'], $time_array['second'], $time_array['month'], $time_array['day'], $time_array['year']);
      }

      $clauses[] = "( {$fieldName} >= $from )";
    }

    if ($to) {
      $to = ($type == CRM_Utils_Type::T_DATE) ? substr($to, 0, 8) : $to;
      if ($type == CRM_Utils_Type::T_TIMESTAMP) {
        $time_array = date_parse_from_format ('YmdHis' ,  $to);
        $to = mktime($time_array['hour'], $time_array['minute'], $time_array['second'], $time_array['month'], $time_array['day'], $time_array['year']);
      }
      $clauses[] = "( {$fieldName} <= {$to} )";
    }

    if (!empty($clauses)) {
      return implode(' AND ', $clauses);
    }

    return NULL;
  }


  function groupBy( ) {
    // required for GROUP_CONCAT
    $this->_groupBy = "GROUP BY {$this->_aliases['civicrm_cdntaxreceiptsfr_log']}.id";
  }

  function postProcess() {

    $this->beginPostProcess();

    $sql = $this->buildQuery(TRUE);

    $rows = $graphRows = array();
    $this->buildRows($sql, $rows);

    $this->formatDisplay($rows);
    $this->doTemplateAssignment($rows);
    $this->endPostProcess($rows);
  }

  function alterDisplay(&$rows) {
    // custom code to alter rows
    $entryFound = FALSE;
    $defined_financial_types = CRM_Contribute_BAO_Contribution::buildOptions('financial_type_id', 'validate');
    $defined_payment_methods = CRM_Contribute_BAO_Contribution::buildOptions('payment_instrument_id', 'validate');

    foreach ($rows as $rowNum => $row) {

      // change contact name with link
      if (array_key_exists('civicrm_contact_sort_name', $row) &&
        array_key_exists('civicrm_contact_id', $row)
      ) {
        require_once('CRM/Utils/System.php');
        $url = CRM_Utils_System::url("civicrm/contact/view",
                  'reset=1&cid=' . $row['civicrm_contact_id'],
                  $this->_absoluteUrl
               );
        $rows[$rowNum]['civicrm_contact_sort_name_link'] = $url;
        $rows[$rowNum]['civicrm_contact_sort_name_hover'] = ts("View Contact Summary for this Contact");
        $entryFound = TRUE;
      }

      if (array_key_exists('civicrm_cdntaxreceiptsfr_log_issue_type', $row)) {
        if ($rows[$rowNum]['civicrm_cdntaxreceiptsfr_log_issue_type'] == 'single' ) {
          $rows[$rowNum]['civicrm_cdntaxreceiptsfr_log_issue_type'] = ts('Single', array('domain' => DOMAINS_CDNTAX_FR));
        }
        elseif ($rows[$rowNum]['civicrm_cdntaxreceiptsfr_log_issue_type'] == 'annual' ) {
          $rows[$rowNum]['civicrm_cdntaxreceiptsfr_log_issue_type'] = ts('Annual', array('domain' => DOMAINS_CDNTAX_FR));
        }
        elseif ($rows[$rowNum]['civicrm_cdntaxreceiptsfr_log_issue_type'] == 'aggregate' ) {
          $rows[$rowNum]['civicrm_cdntaxreceiptsfr_log_issue_type'] = ts('Aggregate', array('domain' => DOMAINS_CDNTAX_FR));
        }
        $entryFound = TRUE;
      }

      if (array_key_exists('civicrm_cdntaxreceiptsfr_log_issue_method', $row)) {
        if ($rows[$rowNum]['civicrm_cdntaxreceiptsfr_log_issue_method'] == 'print' ) {
          $rows[$rowNum]['civicrm_cdntaxreceiptsfr_log_issue_method'] = ts('Print', array('domain' => DOMAINS_CDNTAX_FR));
        }
        elseif ($rows[$rowNum]['civicrm_cdntaxreceiptsfr_log_issue_method'] == 'email' ) {
          $rows[$rowNum]['civicrm_cdntaxreceiptsfr_log_issue_method'] = ts('Email', array('domain' => DOMAINS_CDNTAX_FR));
        }
        $entryFound = TRUE;
      }

      if (array_key_exists('civicrm_cdntaxreceiptsfr_log_receipt_status', $row)) {
        if ($rows[$rowNum]['civicrm_cdntaxreceiptsfr_log_receipt_status'] == 'issued' ) {
          $rows[$rowNum]['civicrm_cdntaxreceiptsfr_log_receipt_status'] = ts('Issued', array('domain' => DOMAINS_CDNTAX_FR));
        }
        elseif ($rows[$rowNum]['civicrm_cdntaxreceiptsfr_log_receipt_status'] == 'cancelled' ) {
          $rows[$rowNum]['civicrm_cdntaxreceiptsfr_log_receipt_status'] = ts('Cancelled', array('domain' => DOMAINS_CDNTAX_FR));
        }
        $entryFound = TRUE;
      }

      if (array_key_exists('civicrm_cdntaxreceiptsfr_log_issued_on', $row)) {
        $rows[$rowNum]['civicrm_cdntaxreceiptsfr_log_issued_on'] = date('Y-m-d', $rows[$rowNum]['civicrm_cdntaxreceiptsfr_log_issued_on']);
        $entryFound = TRUE;
      }

      if (array_key_exists('civicrm_cdntaxreceiptsfr_log_uid', $row)) {
        $issued_by = CRM_Core_BAO_UFMatch::getUFValues($rows[$rowNum]['civicrm_cdntaxreceiptsfr_log_uid']);
        if( $issued_by ) {
          $rows[$rowNum]['civicrm_cdntaxreceiptsfr_log_uid'] = $issued_by['uf_name'];
          $entryFound = TRUE;
        }
      }

      if (array_key_exists('civicrm_line_item_financial_type_id', $row)) {
        $financial_types = explode(',', $row['civicrm_line_item_financial_type_id']);
        $financial_types = array_map(function($t) use ($defined_financial_types) {
          return $defined_financial_types[$t] ?? E::ts('Unknown');
        }, $financial_types);
        $rows[$rowNum]['civicrm_line_item_financial_type_id'] = implode(', ', $financial_types);
        $entryFound = TRUE;
      }

      if (array_key_exists('civicrm_contribution_payment_instrument_id', $row)) {
        $payment_methods = explode(',', $row['civicrm_contribution_payment_instrument_id']);
        $payment_methods = array_map(function($t) use ($defined_payment_methods) {
          return $defined_payment_methods[$t] ?? E::ts('Unknown');
        }, $payment_methods);
        $rows[$rowNum]['civicrm_contribution_payment_instrument_id'] = implode(', ', $payment_methods);
        $entryFound = TRUE;
      }

      // skip looking further in rows, if first row itself doesn't
      // have the column we need
      if (!$entryFound) {
        break;
      }
    }
  }

  function statistics(&$rows) {
    $statistics = parent::statistics($rows);

    $totalAmount = $average = array();
    $count = 0;
    $select = "
        SELECT COUNT({$this->_aliases['civicrm_cdntaxreceiptsfr_log']}.receipt_amount ) as count,
               SUM( {$this->_aliases['civicrm_cdntaxreceiptsfr_log']}.receipt_amount ) as amount,
               ROUND(AVG({$this->_aliases['civicrm_cdntaxreceiptsfr_log']}.receipt_amount), 2) as avg
        ";

    // @todo FIXME
    $where = $this->getRidOfLineItemsAclWhere();
    $sql = "{$select}
      FROM cdntaxreceiptsfr_log {$this->_aliases['civicrm_cdntaxreceiptsfr_log']}
      {$where}";

    $dao = CRM_Core_DAO::executeQuery($sql);

    while ($dao->fetch()) {
      $totalAmount[] = CRM_Utils_Money::format($dao->amount, 'CAD');
      $average[] =   CRM_Utils_Money::format($dao->avg, 'CAD');
      $count += $dao->count;
    }
    $statistics['counts']['amount'] = array(
      'title' => ts('Total Amount Issued', array('domain' => DOMAINS_CDNTAX_FR)),
      'value' => implode(',  ', $totalAmount),
      'type' => CRM_Utils_Type::T_STRING,
    );
    $statistics['counts']['count'] = array(
      'title' => ts('Number Issued', array('domain' => DOMAINS_CDNTAX_FR)),
      'value' => $count,
    );
    $statistics['counts']['avg'] = array(
      'title' => ts('Average Amount Issued', array('domain' => DOMAINS_CDNTAX_FR)),
      'value' => implode(',  ', $average),
      'type' => CRM_Utils_Type::T_STRING,
    );
    return $statistics;
  }

  /**
   * @todo FIXME Core contains a built-in ACL on line items where it restricts
   * the entity_table, but it messes up our grouping here. So as a quickfix
   * this removes it. In this report we know the line items are always related
   * to contributions, but this is still a bit risky and not the right way to
   * do this.
   * @return string
   */
  private function getRidOfLineItemsAclWhere(): string {
    $where = $this->_where;
    $lineItemsAclWhere = implode(' AND ', CRM_Price_BAO_LineItem::getSelectWhereClause($this->_aliases['civicrm_line_item']));
    if (!empty($lineItemsAclWhere) && strpos($where, "AND $lineItemsAclWhere") !== FALSE) {
      $where = str_replace("AND $lineItemsAclWhere", ' ', $where);
    }
    return $where;
  }

}

