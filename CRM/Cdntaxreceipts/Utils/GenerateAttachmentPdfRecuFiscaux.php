<?php
    /**
     * This class provides the common functionality for issuing CDN Tax Receipts for
     * one or a group of contact ids.
     */
    class CRM_Cdntaxreceipts_Utils_GenerateAttachmentPdfRecuFiscaux {
        
        public static function downloadPDF(int $messageTemplateID, array $context, string $filename) {
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
            
            $html = [];
            foreach ($rows as $row) {
                $html[] = $row->render($msgPart);
            }
            
            return $html;
        }
        
    }

