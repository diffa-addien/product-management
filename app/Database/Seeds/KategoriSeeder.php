<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\KategoriModel;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $model = new KategoriModel();
        $data = [
            ['nama_kategori' => 'Alat Musik'],
            ['nama_kategori' => 'Alat Olahraga'] // Duplikat sengaja dimasukkan
        ];

        foreach ($data as &$item) {
            $model->insert($item);
        }
    }
}
