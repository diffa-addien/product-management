<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\ProdukModel;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class PanelController extends BaseController
{
    public function index()
    {
        return redirect()->to('list-produk');
    }

    public function listProduk()
    {
        return view('dir_produk/produk_view');
    }

    public function profil()
    {
        return view('profil_view');
    }

    public function tambahProduk()
    {
        return view('dir_produk/tambah_produk');
    }

    public function updateProduk($produk_id)
    {
        $model = new ProdukModel();
        $produk = $model->find($produk_id);

        if (!$produk) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('dir_produk/update_produk', ['produk' => $produk]);
    }
}
