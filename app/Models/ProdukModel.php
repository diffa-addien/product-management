<?php
namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table      = 'produk';
    protected $primaryKey = 'produk_id';
    protected $returnType = 'array';
    protected $useAutoIncrement = true; // Untuk produk_id
    protected $allowedFields = ['nama_produk', 'kategori', 'harga_beli', 'harga_jual', 'stok', 'gambar'];

    // Validasi opsional
    protected $validationRules = [
        'nama_produk' => 'required|is_unique[produk.nama_produk]',
        'kategori'    => 'required',
        'harga_beli'  => 'required|integer',
        'harga_jual'  => 'required|integer',
        'stok'        => 'required|integer',
        'gambar'      => 'permit_empty|max_length[255]',
    ];

    protected $validationMessages = [
        'nama_produk' => [
            'required'  => 'Nama produk wajib diisi.',
            'is_unique' => 'Nama produk sudah ada, gunakan nama lain.',
        ],
        'kategori' => [
            'required' => 'kategori wajib diisi.',
        ],
        'harga_beli' => [
            'required' => 'Harga beli wajib diisi.',
            'integer'  => 'Harga beli harus berupa angka.',
        ],
        'harga_jual' => [
            'required' => 'Harga jual wajib diisi.',
            'integer'  => 'Harga jual harus berupa angka.',
        ],
        'stok' => [
            'required' => 'Stok wajib diisi.',
            'integer'  => 'Stok harus berupa angka.',
        ],
    ];
}