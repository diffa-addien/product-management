<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class SessionFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Cek apakah ada token dan waktu kedaluwarsa
        $jwtExp = $session->get('jwt_exp');
        $jwtToken = $session->get('jwt_token');

        // Redirect ke login jika token tidak ada
        if (!$jwtToken || !$jwtExp) {
            return redirect()->to("login");
        }

        $currentTime = time();

        // Jika token akan kedaluwarsa dalam 10 menit (600 detik)
        if ($jwtExp - $currentTime < 600) {
            // Decode token lama untuk mendapatkan user_id dan username
            try {
                $decoded = JWT::decode($jwtToken, new Key(getenv('JWT_SECRET'), 'HS256'));

                // Buat token baru
                $newToken = $this->generateToken($decoded->username);

                // Simpan ke session
                $session->set([
                    'jwt_token' => $newToken,
                    'jwt_exp' => time() + 3600, // Perpanjang 1 jam
                    'username' => $decoded->username,
                    'data' => $decoded->data
                ]);

            } catch (\Exception $e) {
                return service('response')->setStatusCode(401)->setJSON(['error' => 'Token tidak valid atau sudah expired.']);
                
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak diperlukan
    }

    private function generateToken($username)
    {
        $issuedAt = time();
        $expireAt = $issuedAt + 3600; // Perpanjang 1 jam

        $payload = [
            "iat" => $issuedAt,
            "exp" => $expireAt,
            "username" => $username
        ];

        return JWT::encode($payload, getenv('JWT_SECRET'), 'HS256');
    }
}
