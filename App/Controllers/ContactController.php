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
        $message = "Mensagem encaminhada com sucesso.";
        redirectWithMessage("/contato", "success", $message);
    }
}