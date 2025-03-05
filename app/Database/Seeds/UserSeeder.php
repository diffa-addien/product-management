<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Masukkan data akun default ke database tabel user
        $model = new UserModel();
        $data = [
            'username'    => 'diffaddien',
            'foto_profil' => '/uploads/profil/blank-profile.webp',
            'full_name'   => 'Diffa Addien Aziz',
            'posisi'      => 'Developer',
            'password'    => 'kandidat#123'
        ];
        $model->insert($data);
    }
}
