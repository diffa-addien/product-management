<?= $this->extend('dir_template/admin_panel') ?>
<?= $this->section("content") ?>
<h2 class="text-2xl font-bold mb-4 text-center">Edit Produk</h2>
<form id="produkForm" enctype="multipart/form-data">
  <div class="mb-4">
    <label class="block text-gray-700">Nama Produk</label>
    <input type="text" name="nama_produk" value="<?= $produk['nama_produk'] ?>" class="w-full p-2 border rounded" readonly required>
  </div>
  <div class="mb-4">
    <label class="block text-gray-700">Kategori</label>
    <input type="text" name="kategori" value="<?= $produk['kategori'] ?>" class="w-full p-2 border rounded" required>
  </div>
  <div class="mb-4">
    <label class="block text-gray-700">Harga Beli</label>
    <input type="number" name="harga_beli" value="<?= $produk['harga_beli'] ?>" class="w-full p-2 border rounded" required>
  </div>
  <div class="mb-4">
    <label class="block text-gray-700">Harga Jual</label>
    <input type="number" name="harga_jual" value="<?= $produk['harga_jual'] ?>" class="w-full p-2 border rounded" required>
  </div>
  <div class="mb-4">
    <label class="block text-gray-700">Stok</label>
    <input type="number" name="stok" value="<?= $produk['stok'] ?>" class="w-full p-2 border rounded" required>
  </div>
  <div class="mb-4">
    <label class="block text-gray-700">Gambar</label>
    <input type="file" accept=".jpg, .jpeg, .png" name="gambar" value="<?= $produk['gambar'] ?>" class="w-full p-2 border rounded">
  </div>
  <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Simpan Perubahan</button>
</form>
<?= $this->endSection("content") ?>

<?= $this->section("script") ?>
<script>
  $('#produkForm').submit(function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const produk_id = <?= $produk['produk_id'] ?>;

    fetch('<?= base_url('api/update-produk/') ?>' + produk_id, {
        method: 'POST',
        headers: {
          'Authorization': 'Bearer <?= session()->get('jwt_token') ?>'
        },
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.status === 200) {
          toastr.success(data.message);
          setTimeout(() => window.location.href = '<?= base_url('list-produk') ?>', 1000);
        } else {
          toastr.error(data.message + (data.errors ? ': ' + JSON.stringify(data.errors) : ''));
        }
      })
      .catch(error => {
        toastr.error('Terjadi kesalahan: ' + error);
      });
  });
</script>
<?= $this->endSection("script") ?>