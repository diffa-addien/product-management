<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'username';
    protected $returnType = 'array';
    protected $allowedFields = ['username', 'foto_profil', 'full_name', 'posisi', 'password'];
    protected $useAutoIncrement = false; // Matikan autoincrement CI4

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }
}
