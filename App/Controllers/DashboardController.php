<?php

namespace App\Controllers;

use App\Http\Request;

class DashboardController {
    public function index(Request $request, $params) {
        $data = $request->body();
        
        return [
            'view' => 'dashboard.php',
            'data' => ['title' => 'Dashboard']
        ];
    }
}