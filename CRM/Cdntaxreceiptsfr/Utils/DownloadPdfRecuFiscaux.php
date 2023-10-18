<?php

/**
 * This class provides the common functionality for issuing CDN Tax Receipts for
 * one or a group of contact ids.
 */
class CRM_Cdntaxreceiptsfr_Utils_DownloadPdfRecuFiscaux
{

    public static function downloadPDF(int $messageTemplateID, array $context, string $filename)
    {
        //$filename = CRM_Utils_File::makeFilenameWithUnicode($filename, '_', 200) . '.pdf';

        $htmlMessage = \Civi\Api4\MessageTemplate::get(FALSE)
            ->addWhere('id', '=', $messageTemplateID)
            ->execute()
            ->first()['msg_html'];

        $tp = new \Civi\Token\TokenProcessor(\Civi::dispatcher(), [
            'controller' => get_class(),
            'smarty' => false,
            'schema' => array_keys($context),
        ]);
        $tp->addMessage('body_html', $htmlMessage, 'text/html');
        $tp->addRow()->context($context);
        $tp->evaluate();

        $rows = $tp->getRows();
        $msgPart = 'body_html';

        $html = [];
        foreach ($rows as $row) {
            //$row->tokens('contribution', 'total_amount', 40);
            $html[] = $row->render($msgPart);
        }
        if (!empty($html)) {
            CRM_Utils_PDF_Utils::html2pdf($html, $filename, FALSE);
        }
    }

    public static function downloadOutputPDF(string $issueType, array $contributions,int $messageTemplateID, array $context, string $filename)
    {
        $filename = CRM_Utils_File::makeFilenameWithUnicode($filename, '_', 200) . '.pdf';

        $htmlMessage = \Civi\Api4\MessageTemplate::get(FALSE)
            ->addWhere('id', '=', $messageTemplateID)
            ->execute()
            ->first()['msg_html'];

        $tp = new \Civi\Token\TokenProcessor(\Civi::dispatcher(), [
            'controller' => get_class(),
            'smarty' => false,
            'schema' => array_keys($context),
        ]);
        $tp->addMessage('body_html', $htmlMessage, 'text/html');
        $tp->addRow()->context($context);
        $tp->evaluate();

        $rows = $tp->getRows();
        $msgPart = 'body_html';
        $amountRFAggregate = 0;
        
        if($issueType == 'aggregate') {
            if(count($contributions) > 0) {
                $amountContributions = array_column($contributions,'receipt_amount');
                $sumAmountContributions = array_sum($amountContributions);
                $amountRFAggregate = $sumAmountContributions;
            }
        }

        $html = [];
        foreach ($rows as $row) {
            if($issueType == 'aggregate') {
                $row->tokens('contribution', 'total_amount', $amountRFAggregate . ' Euros');
            }
            $html[] = $row->render($msgPart);
        }
        
        if (!empty($html)) {
            $output = CRM_Utils_PDF_Utils::html2pdf($html, $filename, true);
            
            $uploads = wp_upload_dir();
            $upload_path = $uploads['path']; // /var/aegir/platforms/wordpress-dev/sites/wpdev.pec.symbiodev.xyz/wp-content/uploads/2023/03

            $filePath = $upload_path . DIRECTORY_SEPARATOR . $filename;
            file_put_contents($filePath, $output);
            return $filePath;
        }

        return null;
    }
}
