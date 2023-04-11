<div class="crm-block crm-form-block crm-miscellaneous-form-block">

  <h3>{ts domain='org.civicrm.cdntaxreceiptsfr'}Global settings{/ts}</h3>

  <div class="status message">
    <strong>Information:</strong>{ts domain='org.civicrm.cdntaxreceiptsfr'}This section is a global settings of the module (receipt prefx, email message, system option, ...){/ts}
  </div>

  <h3>{ts domain='org.civicrm.cdntaxreceiptsfr'}Settings receipt prefix{/ts}</h3>

  <table class="form-layout">
    <tbody>
    <tr>
      <td class="label">{$form.receipt_prefix.label}</td>
      <td class="content">{$form.receipt_prefix.html}
        <p class="description">{ts domain='org.civicrm.cdntaxreceiptsfr'}Receipt numbers are formed by appending the CiviCRM Contribution ID to this prefix. Receipt numbers must be unique within your organization. If you also issue tax receipts using another system, you can use the prefix to ensure uniqueness (e.g. enter 'WEB-' here so all receipts issued through CiviCRM are WEB-00000001, WEB-00000002, etc.){/ts}</p></td>
    </tr>
    </tbody>
  </table>

  <h3>{ts domain='org.civicrm.cdntaxreceiptsfr'}System Options{/ts}</h3>

  <table class="form-layout">
    <tbody>
    <tr>
      <td class="label">{$form.issue_inkind.label}</td>
      <td class="content">{$form.issue_inkind.html}
        <p class="description">{ts domain='org.civicrm.cdntaxreceiptsfr'}Checking this box will set up the fields required to generate in-kind tax receipts. Unchecking the box will not disable in-kind receipts: you will need to do that manually, by disabling the In-kind contribution type or making it non-deductible in the CiviCRM administration pages.{/ts}</p></td>
    </tr>
    <tr>
      <td class="label">{$form.delivery_method.label}</td>
      <td class="content">{$form.delivery_method.html}
        <p class="description">{ts domain='org.civicrm.cdntaxreceiptsfr'}Print only: all tax receipts are generated in PDF format.<br />Email or print: tax receipts are emailed if possible, otherwise generated in PDF format.<br />Data only: Tax receipts are generated internally in CiviCRM. Data can be exported for mail merge/mail house via the Tax Receipts Issued report.{/ts}</p></td>
    </tr>
    <tr>
      <td class="label">{$form.attach_to_workflows.label}</td>
      <td class="content">{$form.attach_to_workflows.html}
        <p class="description">{ts domain='org.civicrm.cdntaxreceiptsfr'}** Not recommended if you have ACHEFT payments. **<br />If enabled, tax receipts will be attached to the automated emails that CiviCRM sends via online contribution page, and when "send receipt" is selected during backoffice gift entry. Be sure to alter the Contributions - Receipt (on-line/off-line) message templates to alert the donor that their tax receipt is attached.{/ts}</p></td>
    </tr>
    <tr>
      <td class="label">{$form.enable_advanced_eligibility_report.label}</td>
      <td class="content">{$form.enable_advanced_eligibility_report.html}
        <p class="description">{ts domain='org.civicrm.cdntaxreceiptsfr'}If enabled, the Receipts not issued Report will have the Advanced Eligibility Check enabled by default. Required for accurate reports, but can slow reports.{/ts}</p></td>
    </tr>
    </tbody>
  </table>

  <h3>{ts domain='org.civicrm.cdntaxreceiptsfr'}Email Message{/ts}</h3>

  <table class="form-layout">
    <tbody>
    <tr>
      <td class="label">{$form.email_from.label}</td>
      <td class="content">{$form.email_from.html}
        <p class="description">{ts domain='org.civicrm.cdntaxreceiptsfr'}Address you would like to Email the Tax Receipt from.{/ts}</p></td>
    </tr>
    <tr>
      <td class="label">{$form.email_archive.label}</td>
      <td class="content">{$form.email_archive.html}
        <p class="description">{ts domain='org.civicrm.cdntaxreceiptsfr'}Address you would like to Send a copy of the Email containing the Tax Receipt to. This is useful to create an archive.{/ts}</p></td>
    </tr>
    <tr>
      <td class="label">{ts domain='org.civicrm.cdntaxreceiptsfr'}Message{/ts}</td>
      <td class="content"><p class="description">{ts domain='org.civicrm.cdntaxreceiptsfr'}The email message is configured under "System Workflow Messages" in Communication Templates.{/ts}</p></td>
    </tr>
    </tbody>
  </table>

  <table class="form-layout wrapper-template-pdf" data-attributes="{$form.developper_or_not.value}">
    <tbody>
    <tr>
      <td class="label">{$form.developper_or_not.label}</td>
      <td class="content">{$form.developper_or_not.html}
        <p class="description">{ts domain='org.civicrm.cdntaxreceiptsfr'}Choose how to issue your receipt ? : <br> issue your receipt with a message template <br> issue your receipt with TCPDF libraries (developper){/ts}</p></td>
    </tr>
    </tbody>
  </table>

  <div class="crm-accordion-wrapper accordion-modeltemp open">
    <div class="crm-accordion-header">
      {ts domain='org.civicrm.cdntaxreceiptsfr'}Settings with model of message of CiviCRM{/ts}
    </div>
    <div class="crm-accordion-body">
      <div class="crm-block crm-form-block crm-form-title-here-form-block">

        <table class="form-layout">
          <tbody>
          <tr>
            <!-- ajout modele de message pour le reçu fiscal -->
            <h4>Choose model message for generate pdf receipt</h4>
            <td class="label">{$form.modeltemp.label}</td>
            <td class="content">{$form.modeltemp.html}
              <p class="description">{ts domain='org.civicrm.cdntaxreceiptsfr'}Choose template model for generate a custom receipt for france.{/ts}</td>
          </tr>
          </tbody>
        </table>

      </div>
    </div>
  </div>

  <div class="crm-accordion-wrapper accordion-developper open">
    <div class="crm-accordion-header">
      {ts domain='org.civicrm.cdntaxreceiptsfr'}Settings for the TCPDF libraries (developper section){/ts}
    </div>
    <div class="crm-accordion-body">
      <div class="crm-block crm-form-block crm-form-title-here-form-block">

        <table class="form-layout">
          <tbody>
          <tr>
            <td class="label">{$form.org_name.label}</td>
            <td class="content">{$form.org_name.html}
              <p class="description">{ts domain='org.civicrm.cdntaxreceiptsfr'}My Charitable Organization{/ts}</p></td>
          </tr>
          <tr>
            <td class="label">{$form.org_address_line1.label}</td>
            <td class="content">{$form.org_address_line1.html}
              <p class="description">{ts domain='org.civicrm.cdntaxreceiptsfr'}101 Anywhere Drive{/ts}</p></td>
          </tr>
          <tr>
            <td class="label">{$form.org_address_line2.label}</td>
            <td class="content">{$form.org_address_line2.html}
              <p class="description">{ts domain='org.civicrm.cdntaxreceiptsfr'}Toronto ON A1B 2C3{/ts}</p></td>
          </tr>
          <tr>
            <td class="label">{$form.org_tel.label}</td>
            <td class="content">{$form.org_tel.html}
              <p class="description">(555) 555-5555</p></td>
          </tr>
          <tr>
            <td class="label">{$form.org_fax.label}</td>
            <td class="content">{$form.org_fax.html}
              <p class="description">(555) 555-5555</p></td>
          </tr>
          <tr>
            <td class="label">{$form.org_email.label}</td>
            <td class="content">{$form.org_email.html}
              <p class="description">info@my.org</p></td>
          </tr>
          <tr>
            <td class="label">{$form.org_web.label}</td>
            <td class="content">{$form.org_web.html}
              <p class="description">www.my.org</p></td>
          </tr>
          <tr>
            <td class="label">{$form.receipt_authorized_signature_text.label}</td>
            <td class="content">{$form.receipt_authorized_signature_text.html}
              <p class="description">{ts domain='org.civicrm.cdntaxreceiptsfr'}Name and position of the authorizing official to be displayed under the signature line. Defaults to "Authorized Signature" if no name is specified.{/ts}</p></td>
          </tr>
          <tr>
            <td class="label">{$form.receipt_logo.label}</td>
            <td class="content">{$form.receipt_logo.html}
              <p class="description">{ts domain='org.civicrm.cdntaxreceiptsfr'}Logo size: 280x120 pixels; File types allowed: .jpg .png.{/ts}</p>
              {if $receipt_logo}
                {if $receipt_logo_class}<span class="crm-error">The file {$receipt_logo} was not found</span>
                {else}<p class="label">Current {$form.receipt_logo.label}: {$receipt_logo}<span class="cdntaxreceipts-imagedelete"><a href="{crmURL p='civicrm/cdntaxreceiptsfr/imagedelete' q='type=receipt_logo'}">{ts}Delete{/ts}</a></span></p>{/if}
              {/if}</td>
          </tr>
          <tr>
            <td class="label">{$form.receipt_signature.label}</td>
            <td class="content">{$form.receipt_signature.html}
              <p class="description">{ts domain='org.civicrm.cdntaxreceiptsfr'}Signature size: 141x58 pixels; File types allowed: .jpg .png.{/ts}</p>
              {if $receipt_signature}
                {if $receipt_signature_class}<span class="crm-error">The file {$receipt_signature} was not found</span>
                {else}<p class="label">Current {$form.receipt_signature.label}: {$receipt_signature}<span class="cdntaxreceipts-imagedelete"><a href="{crmURL p='civicrm/cdntaxreceiptsfr/imagedelete' q='type=receipt_signature'}">{ts}Delete{/ts}</a></span></p>{/if}
              {/if}</td>
          </tr>
          <tr>
            <td class="label">{$form.receipt_watermark.label}</td>
            <td class="content">{$form.receipt_watermark.html}
              <p class="description">{ts domain='org.civicrm.cdntaxreceiptsfr'}Watermark Image size: 250x250 pixels; File types allowed: .jpg .png.{/ts}</p>
              {if $receipt_watermark}
                {if $receipt_watermark_class}<span class="crm-error">The file {$receipt_watermark} was not found</span>
                {else}<p class="label">Current {$form.receipt_watermark.label}: {$receipt_watermark}<span class="cdntaxreceipts-imagedelete"><a href="{crmURL p='civicrm/cdntaxreceiptsfr/imagedelete' q='type=receipt_watermark'}">{ts}Delete{/ts}</a></span></p>{/if}
              {/if}</td>
          </tr>
          <tr>
            <td class="label">{$form.receipt_pdftemplate.label}</td>
            <td class="content">{$form.receipt_pdftemplate.html}
              <p class="description">{ts domain='org.civicrm.cdntaxreceiptsfr'}Upload your own PDF template: .pdf{/ts}</p>
              {if $receipt_pdftemplate}
                {if $receipt_pdftemplate_class}<span class="crm-error">The file {$receipt_pdftemplate} was not found</span>
                {else}<p class="label">Current {$form.receipt_pdftemplate.label}: {$receipt_pdftemplate}<span class="cdntaxreceipts-imagedelete"><a href="{crmURL p='civicrm/cdntaxreceiptsfr/imagedelete' q='type=receipt_pdftemplate'}">{ts}Delete{/ts}</a></span></p>{/if}
              {/if}</td>
          </tr>
          <tr>
            <td class="label">{$form.source_field.label}</td>
            <td class="content">{$form.source_field.html|crmAddClass:huge}&nbsp;<input class="crm-token-selector big" data-field="source_field" />
              <p class="description">{ts domain='org.civicrm.cdntaxreceiptsfr'}Either replace with a token string or blank out to hide the field.{/ts}</td>
          </tr>
          <tr>
            <td class="label">{$form.source_label.label}</td>
            <td class="content">{$form.source_label.html}
              <p class="description">{ts domain='org.civicrm.cdntaxreceiptsfr'}Label to use for the Source field. Include a space at the end to provide spacing between the label and the value.{/ts}</td>
          </tr>
          </tbody>
        </table>

      </div>
    </div>
  </div>

{* FOOTER *}
<div class="crm-submit-buttons">
{include file="CRM/common/formButtons.tpl" location="bottom"}
</div>

</div>
{* the InsertTokens needs this for some reason *}
<div id="editMessageDetails"></div>
{include file='CRM/Mailing/Form/InsertTokens.tpl'}

{literal}
  <script type="text/javascript">
    CRM.$(function($){

      const el = $('.wrapper-template-pdf');

      $('.accordion-developper').hide();
      $('.accordion-modeltemp').hide();

      var inputDevelopperOrNot = el.find('input');
      inputDevelopperOrNot.each(function (){
        $(this).on('change', function (){

          if($(this).val() === '1') {
            $('.accordion-modeltemp').hide();
            $('.accordion-developper').show();
          } else if ($(this).val() === '0') {
            $('.accordion-developper').hide();
            $('.accordion-modeltemp').show();
          } else {
            console.log('default');
          }

        });
      });
    });
  </script>
{/literal}