<?php

/**
 * This class provides the common functionality for issuing Annual Tax Receipts for
 * one or a group of contact ids.
 */
class CRM_Cdntaxreceiptsfr_Task_IssueAnnualTaxReceipts extends CRM_Contact_Form_Task {

  const MAX_RECEIPT_COUNT = 1000;

  private $_receipts;
  private $_years;

  /**
   * build all the data structures needed to build the form
   *
   * @return void
   * @access public
   */
  function preProcess() {

    //check for permission to edit contributions
    if ( ! CRM_Core_Permission::check('issue cdn tax receipts') ) {
      CRM_Core_Error::fatal(ts('You do not have permission to access this page', array('domain' => DOMAINS_CDNTAX_FR)));
    }

    parent::preProcess();

    $thisYear = date("Y");
    $this->_years = array($thisYear, $thisYear - 1, $thisYear - 2);

    $receipts = array();
    foreach ( $this->_years as $year ) {
      $receipts[$year] = array('email' => 0, 'print' => 0, 'data' => 0, 'total' => 0, 'contrib' => 0);
    }

    // count and categorize contributions
    foreach ( $this->_contactIds as $id ) {
      foreach ( $this->_years as $year ) {
        [ $issuedOn, $receiptId ] = cdntaxreceiptsfr_annual_issued_on($id, $year);

        $eligible = count(cdntaxreceiptsfr_contributions_not_receipted($id, $year));
        if ( $eligible > 0 ) {
          [ $method, $email ] = cdntaxreceiptsfr_sendMethodForContact($id);
          $receipts[$year][$method]++;
          $receipts[$year]['total']++;
          $receipts[$year]['contrib'] += $eligible;
        }
      }
    }

    $this->_receipts = $receipts;

  }

  /**
   * Build the form
   *
   * @access public
   *
   * @return void
   */
  function buildQuickForm() {

    CRM_Utils_System::setTitle(ts('Issue Annual Tax Receipts', array('domain' => DOMAINS_CDNTAX_FR)));

    CRM_Core_Resources::singleton()->addStyleFile(DOMAINS_CDNTAX_FR, 'css/civicrm_cdntaxreceipts.css');

    // assign the counts
    $receipts = $this->_receipts;
    $receiptTotal = 0;
    foreach ( $this->_years as $year ) {
      $receiptTotal += $receipts[$year]['total'];
    }

    $this->assign('receiptCount', $receipts);
    $this->assign('receiptTotal', $receiptTotal);
    $this->assign('receiptYears', $this->_years);

    $delivery_method = Civi::settings()->get('delivery_method') ?? CDNTAX_FR_DELIVERY_PRINT_ONLY;
    $this->assign('deliveryMethod', $delivery_method);

    // add radio buttons
    foreach ( $this->_years as $year ) {
      $this->addElement('radio', 'receipt_year', NULL, $year, 'issue_' . $year);
    }
    $this->addRule('receipt_year', ts('Selection required', array('domain' => DOMAINS_CDNTAX_FR)), 'required');

    if ($delivery_method != CDNTAX_FR_DELIVERY_DATA_ONLY) {
      $this->add('checkbox', 'is_preview', ts('Run in preview mode?', array('domain' => DOMAINS_CDNTAX_FR)));
    }

    $buttons = array(
      array(
        'type' => 'cancel',
        'name' => ts('Back', array('domain' => DOMAINS_CDNTAX_FR)),
      ),
      array(
        'type' => 'next',
        'name' => 'Issue Tax Receipts',
        'isDefault' => TRUE,
        'submitOnce' => TRUE,
      ),
    );
    $this->addButtons($buttons);

  }

  function setDefaultValues() {
    return array('receipt_year' => 'issue_' . (date("Y") - 1),);
  }

  /**
   * process the form after the input has been submitted and validated
   *
   * @access public
   *
   * @return None
   */

  function postProcess() {

    // lets get around the time limit issue if possible
    if ( ! ini_get( 'safe_mode' ) ) {
      set_time_limit( 0 );
    }

    $params = $this->controller->exportValues($this->_name);
    $year = $params['receipt_year'];
    if ( $year ) {
      $year = substr($year, strlen('issue_')); // e.g. issue_2012
    }

    $previewMode = FALSE;
    if (isset($params['is_preview']) && $params['is_preview'] == 1 ) {
      $previewMode = TRUE;
    }

    /**
     * Drupal module include
     */
    //module_load_include('.inc','civicrm_cdntaxreceipts','civicrm_cdntaxreceipts');f
    //module_load_include('.module','civicrm_cdntaxreceipts','civicrm_cdntaxreceipts');

    // start a PDF to collect receipts that cannot be emailed
    $receiptsForPrinting = cdntaxreceiptsfr_openCollectedPDF();

    $emailCount = 0;
    $printCount = 0;
    $dataCount = 0;
    $failCount = 0;

    foreach ($this->_contactIds as $contactId ) {

      [ $issuedOn, $receiptId ] = cdntaxreceiptsfr_annual_issued_on($contactId, $year);
      $contributions = cdntaxreceiptsfr_contributions_not_receipted($contactId, $year);

      if ( $emailCount + $printCount + $failCount >= self::MAX_RECEIPT_COUNT ) {
        $status = ts('Maximum of %1 tax receipt(s) were sent. Please repeat to continue processing.', array(1=>self::MAX_RECEIPT_COUNT, 'domain' => DOMAINS_CDNTAX_FR));
        CRM_Core_Session::setStatus($status, '', 'info');
        break;
      }

      if ( empty($issuedOn) && count($contributions) > 0 ) {

        [ $ret, $method ] = cdntaxreceiptsfr_issueAnnualTaxReceipt($contactId, $year, $receiptsForPrinting, $previewMode);

        if ( $ret == 0 ) {
          $failCount++;
        }
        elseif ( $method == 'email' ) {
          $emailCount++;
        }
        elseif ( $method == 'print') {
          $printCount++;
        }
        elseif ( $method == 'data') {
          $dataCount++;
        }
      }
    }

    // 3. Set session status
    if ( $previewMode ) {
      $status = ts('%1 tax receipt(s) have been previewed.  No receipts have been issued.', array(1=>$printCount, 'domain' => DOMAINS_CDNTAX_FR));
      CRM_Core_Session::setStatus($status, '', 'success');
    }
    else {
      if ($emailCount > 0) {
        $status = ts('%1 tax receipt(s) were sent by email.', array(1=>$emailCount, 'domain' => DOMAINS_CDNTAX_FR));
        CRM_Core_Session::setStatus($status, '', 'success');
      }
      if ($printCount > 0) {
        $status = ts('%1 tax receipt(s) need to be printed.', array(1=>$printCount, 'domain' => DOMAINS_CDNTAX_FR));
        CRM_Core_Session::setStatus($status, '', 'success');
      }
      if ($dataCount > 0) {
        $status = ts('Data for %1 tax receipt(s) is available in the Tax Receipts Issued report.', array(1=>$dataCount, 'domain' => DOMAINS_CDNTAX_FR));
        CRM_Core_Session::setStatus($status, '', 'success');
      }
    }

    if ( $failCount > 0 ) {
      $status = ts('%1 tax receipt(s) failed to process.', array(1=>$failCount, 'domain' => DOMAINS_CDNTAX_FR));
      CRM_Core_Session::setStatus($status, '', 'error');
    }

    // 4. send the collected PDF for download
    // NB: This exits if a file is sent.
    cdntaxreceiptsfr_sendCollectedPDF($receiptsForPrinting, 'Receipts-To-Print-' . (int) $_SERVER['REQUEST_TIME'] . '.pdf');  // EXITS.
  }
}

