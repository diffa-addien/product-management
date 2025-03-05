<?php

namespace App\Controllers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Home extends BaseController
{
    public function index()
    {
        return redirect()->to('login');
    }

    public function login()
    {
        return view('login_view');
    }

    public function startSession()
    {
        $token = $_GET['token'] ?? '';
        
        try {
            $decoded = JWT::decode($token, new Key(getenv('JWT_SECRET'), 'HS256'));
            // Set session from JWT
            $session = \Config\Services::session();
            $session->set('jwt_exp', $decoded->exp);
            $session->set('jwt_token', $token);
            $session->set('username', $decoded->username);
            $session->set('data', $decoded->data);

            return redirect()->to('list-produk');

        } catch (\Exception $e) {
            return redirect()->to('login');
        }
    }
}
