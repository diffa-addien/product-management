<?= $this->extend('dir_template/admin_panel') ?>
<?= $this->section("content") ?>
<h2 class="text-2xl font-bold mb-4 text-center">Tambah Produk Baru</h2>
        <form id="produkForm" enctype="multipart/form-data">
            <div class="mb-4">
                <label class="block text-gray-700">Nama Produk</label>
                <input type="text" name="nama_produk" class="w-full p-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Kategori</label>
                <input type="text" name="kategori" class="w-full p-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Harga Beli</label>
                <input type="number" name="harga_beli" class="w-full p-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Harga Jual</label>
                <input type="number" name="harga_jual" class="w-full p-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Stok</label>
                <input type="number" name="stok" class="w-full p-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Gambar (URL)</label>
                <input type="file" name="gambar" accept=".jpg, .jpeg, .png" class="w-full p-2 border rounded">
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Simpan</button>
        </form>
<?= $this->endSection("content") ?>

<?= $this->section("script") ?>
<script>
        $('#produkForm').submit(function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch('<?= base_url('api/tambah-produk') ?>', {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer <?=session()->get('jwt_token')?>'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 201) {
                    toastr.success(data.message);
                    setTimeout(() => window.location.href = '<?= base_url('list-produk') ?>', 1000);
                } else {
                    toastr.error(data.message + ': ' + JSON.stringify(data.errors));
                    console.log("gagal");
                }
            })
            .catch(error => {
                toastr.error('Terjadi kesalahan: ' + error);
            });
        });
    </script>
<?= $this->endSection("script") ?>