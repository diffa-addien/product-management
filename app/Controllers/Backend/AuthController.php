<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\UserModel;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController extends BaseController
{
    public function login()
    {
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $model = new UserModel();
        $user = $model->find($username);

        if (!$user || !password_verify($password, $user['password'])) {
            return $this->response->setJSON(['message' => 'Invalid username or password'])->setStatusCode(401);
        }

        // Payload untuk JWT
        $payload = [
            'iat'  => time(),            // Issued at
            'exp'  => time() + 7200,    // Expired dalam 2 jam
            'username'  => $user['username'], // Subject (username)
            'data' => [
                'full_name'   => $user['full_name'],
                'posisi'      => $user['posisi'],
                'foto_profil' => $user['foto_profil'],
            ]
        ];

        // Generate JWT
        $token = JWT::encode($payload, getenv('JWT_SECRET'), 'HS256');

        $response = [
            'status'   => 200,
            'message'  => 'Login successful',
            'token'    => $token,
            'data'     => [
                'username'    => $user['username'],
                'full_name'   => $user['full_name'],
                'posisi'      => $user['posisi'],
                'foto_profil' => $user['foto_profil'],
            ]
        ];

        return $this->response->setJSON($response);
    }

    public function logout()
    {
        //
    }
}
