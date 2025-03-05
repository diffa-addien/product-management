<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProdukTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'produk_id' => [
                'type'           => 'SERIAL',
                'unsigned'       => true,
                'auto_increment' => true, // AI Aktif
            ],
            'nama_produk' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
                'unique'     => true, // Nama harus unik
            ],
            'kategori' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'harga_beli' => [
                'type'       => 'INTEGER',
                'null'       => false,
            ],
            'harga_jual' => [
                'type'       => 'INTEGER',
                'null'       => false,
            ],
            'stok' => [
                'type'       => 'INTEGER',
                'null'       => false,
            ],
            'gambar' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true, // Opsional
            ],
        ]);
        $this->forge->addPrimaryKey('produk_id');
        $this->forge->createTable('produk');
    }

    public function down()
    {
        $this->forge->dropTable('produk');
    }
}
