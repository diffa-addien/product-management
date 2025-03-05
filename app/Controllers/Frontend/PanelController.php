<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\ProdukModel;
use App\Models\KategoriModel;
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
        $model = new KategoriModel();
        $katego = $model->findAll();
        $data['katego'] = $katego;
        return view('dir_produk/produk_view', $data);
    }

    public function profil()
    {
        return view('profil_view');
    }

    public function tambahProduk()
    {
        $model = new KategoriModel();
        $katego = $model->findAll();
        $data['katego'] = $katego;
        return view('dir_produk/tambah_produk', $data);
    }

    public function updateProduk($produk_id)
    {
        $model = new ProdukModel();
        $data['produk'] = $model->find($produk_id);
        $katModel = new KategoriModel();
        $katego = $katModel->findAll();
        $data['katego'] = $katego;

        if (!$data['produk']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('dir_produk/update_produk', $data);
    }
}
