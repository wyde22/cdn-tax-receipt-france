<?php
// This file declares a managed database record of type "ReportTemplate".
// The record will be automatically inserted, updated, or deleted from the
// database as appropriate. For more details, see "hook_civicrm_managed" at:
// http://wiki.civicrm.org/confluence/display/CRMDOC42/Hook+Reference
return array (
  0 => 
  array (
    'name' => 'CRM_Cdntaxreceiptsfr_Form_Report_ReceiptsIssued',
    'entity' => 'ReportTemplate',
    'params' => 
    array (
      'version' => 3,
      'label' => 'Tax Receipts FR - Receipts Issued',
      'description' => 'Tax Receipts FR - ReceiptsIssued (org.civicrm.cdntaxreceiptsfr)',
      'class_name' => 'CRM_Cdntaxreceiptsfr_Form_Report_ReceiptsIssued',
      'report_url' => 'cdntaxreceiptsfr/receiptsissued',
      'component' => 'CiviContribute',
    ),
  ),
);
