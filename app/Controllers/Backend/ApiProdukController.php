<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\ProdukModel;

class ApiProdukController extends BaseController
{
    public function index()
    {
        $model = new ProdukModel();
        $data = $model->findAll();

        return $this->response->setJSON([
            'status'  => 200,
            'message' => 'Data retrieved successfully',
            'data'    => $data
        ]);
    }

    public function create()
    {
        $model = new ProdukModel();
        $data = [
            'nama_produk' => $this->request->getVar('nama_produk'),
            'harga_beli'  => $this->request->getVar('harga_beli'),
            'kategori'    => $this->request->getVar('kategori'),
            'harga_jual'  => $this->request->getVar('harga_jual'),
            'stok'        => $this->request->getVar('stok'),
            'gambar'      => $this->request->getVar('gambar') // Nanti bisa diganti dengan upload file
        ];

        // Ambil file gambar
        $fileGambar = $this->request->getFile('gambar');

        // Atur validasi khusus untuk gambar
        $rules = [
            'gambar' => 'uploaded[gambar]|max_size[gambar,102]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
        ];

        if (!$this->validate($rules)) {
            $validation = \Config\Services::validation();
            return $this->response->setJSON([
                'status'  => 400,
                'message' => 'Validasi gagal',
                'errors'  => $validation->getErrors()
            ]);
        }

        // Proses upload gambar
        if ($fileGambar->isValid() && !$fileGambar->hasMoved()) {

            $namaFile = "Gambar_Artikel_" . date("Y-m-d_H-i-s") . '.' . $fileGambar->guessExtension(); // Buat nama file unik
            $fileGambar->move('uploads', $namaFile);

            // Tambahkan path file ke data
            $data['gambar'] = 'uploads/' . $namaFile;
        }

        if ($model->insert($data)) {
            return $this->response->setJSON([
                'status'  => 201,
                'message' => 'Produk berhasil ditambahkan',
                'data'    => $data
            ]);
        } else {
            return $this->response->setJSON([
                'status'  => 400,
                'message' => 'Gagal menambahkan produk',
                'errors'  => $model->errors()
            ])->setStatusCode(400);
        }
    }

    public function update($produk_id = null)
    {
        $model = new ProdukModel();

        $data = [
           
            'kategori'    => $this->request->getPost('kategori'),
            'harga_beli'  => $this->request->getPost('harga_beli'),
            'harga_jual'  => $this->request->getPost('harga_jual'),
            'stok'        => $this->request->getPost('stok'),
        ];

        // Cek apakah produk ada
        if (!$model->find($produk_id)) {
            return $this->response->setJSON([
                'status'  => 404,
                'message' => 'Produk tidak ditemukan'
            ])->setStatusCode(404);
        }

        // Ambil file gambar
        $fileGambar = $this->request->getFile('gambar');

        // Atur validasi khusus untuk gambar
        $rules = [
            'gambar' => 'max_size[gambar,102]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
        ];

        if (!$this->validate($rules)) {
            $validation = \Config\Services::validation();
            return $this->response->setJSON([
                'status'  => 400,
                'message' => 'Validasi gagal',
                'errors'  => $validation->getErrors()
            ]);
        }

        // Proses upload gambar
        if ($fileGambar->isValid() && !$fileGambar->hasMoved()) {

            $namaFile = "Gambar_Artikel_" . date("Y-m-d_H-i-s") . '.' . $fileGambar->guessExtension(); // Buat nama file unik
            $fileGambar->move('uploads', $namaFile);

            // Tambahkan path file ke data
            $data['gambar'] = 'uploads/' . $namaFile;
        }

        // Update data
        if ($model->update($produk_id, $data)) {
            return $this->response->setJSON([
                'status'  => 200,
                'message' => 'Produk berhasil diperbarui',
                'data'    => $data
            ]);
        } else {
            return $this->response->setJSON([
                'status'  => 400,
                'message' => 'Gagal memperbarui produk',
                'errors'  => $model->errors()
            ])->setStatusCode(400);
        }
    }

    public function delete($produk_id = null)
    {
        $model = new ProdukModel();

        // Cek apakah produk ada
        if (!$model->find($produk_id)) {
            return $this->response->setJSON([
                'status'  => 404,
                'message' => 'Produk tidak ditemukan'
            ])->setStatusCode(404);
        }

        // Hapus produk
        if ($model->delete($produk_id)) {
            return $this->response->setJSON([
                'status'  => 200,
                'message' => 'Produk berhasil dihapus'
            ]);
        } else {
            return $this->response->setJSON([
                'status'  => 400,
                'message' => 'Gagal menghapus produk'
            ])->setStatusCode(400);
        }
    }
}
