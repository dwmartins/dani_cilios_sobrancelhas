<?php

namespace App\Controllers;

use App\Services\SendEmail;
use Exception;

class SendEmailController {
    private $mailSend;

    public function __construct() {
        $this->mailSend = new SendEmail();
    }

    public function contact(array $data) {
        try {
            include(__DIR__."/../EmailTemplates/contact.php");
            $template = ob_get_clean();

            $template = str_replace('{SITENAME}', "Dani Cílios & Sobrancelhas", $template);
            $template = str_replace('{CONTACT_NAME}', $data['name'], $template);
            $template = str_replace('{CONTACT_LASTNAME}', $data['lastName'], $template);
            $template = str_replace('{CONTACT_EMAIL}', $data['email'], $template);
            $template = str_replace('{CONTACT_MESSAGE}', $data['message'], $template);

            $this->mailSend->setTo($_ENV['RECEIVE_EMAIL']);
            $this->mailSend->setSubject("Mensagem do site Dani Cílios & Sobrancelhas");
            $this->mailSend->setTemplate($template);
            $this->mailSend->send($siteInfo);

            return true;
        } catch (Exception $e) {
            logError($e->getMessage());
            throw $e;
        }
    }
}