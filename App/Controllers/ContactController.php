<?php

namespace App\Controllers;

use App\Http\Request;

class ContactController {
    public function index(Request $request, $params) {
        return [
            'view' => 'contact.php',
            'data' => ['title' => 'Contato | Dani Cílios & Sobrancelhas']
        ];
    }

    public function sendMessage(Request $request, $params) {
        try {
            $data = $request->body();

            $sendEmailController = new SendEmailController();
            $sendEmailController->contact($data);

            redirectWithMessage("/contato", "success", "Mensagem encaminhada com sucesso.");
        } catch (\Exception $e) {
            logError($e->getMessage());
            redirectWithMessage("/contato", "error", "Oops, houve um erro, tente novamente.");
        }
    }
}