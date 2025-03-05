<?php
namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table      = 'kategori';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['nama_kategori'];

    // Validasi opsional
    protected $validationRules = [
        'nama_kategori' => 'required|max_length[100]',
    ];

    protected $validationMessages = [
        'nama_kategori' => [
            'required' => 'Nama kategori wajib diisi.',
            'max_length' => 'Nama kategori maksimal 100 karakter.',
        ],
    ];
}