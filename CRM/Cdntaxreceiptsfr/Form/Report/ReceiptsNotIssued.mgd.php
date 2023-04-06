<?php
// This file declares a managed database record of type "ReportTemplate".
// The record will be automatically inserted, updated, or deleted from the
// database as appropriate. For more details, see "hook_civicrm_managed" at:
// http://wiki.civicrm.org/confluence/display/CRMDOC42/Hook+Reference
return array (
  0 => 
  array (
    'name' => 'CRM_Cdntaxreceiptsfr_Form_Report_ReceiptsNotIssued',
    'entity' => 'ReportTemplate',
    'params' => 
    array (
      'version' => 3,
      'label' => 'Tax Receipts FR - Receipts Not Issued',
      'description' => 'Tax Receipts FR - Receipts Not Issued (org.civicrm.cdntaxreceiptsfr)',
      'class_name' => 'CRM_Cdntaxreceiptsfr_Form_Report_ReceiptsNotIssued',
      'report_url' => 'cdntaxreceiptsfr/receiptsnotissued',
      'component' => 'CiviContribute',
    ),
  ),
);
