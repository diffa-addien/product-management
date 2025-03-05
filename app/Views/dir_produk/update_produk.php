<?= $this->extend('dir_template/admin_panel') ?>
<?= $this->section("content") ?>
<h2 class="text-2xl font-bold mb-4 text-center">Edit Produk</h2>

<form id="produkForm" enctype="multipart/form-data" class="grid grid-cols-2 gap-4">
  <!-- Kolom Kiri -->
  <div class="mb-4">
    <label class="block text-gray-700">Kategori</label>
    <select name="kategori" class="w-full p-2 border rounded border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
      <option value="">Pilih Kategori</option>
      <?php foreach ($katego as $kate): ?>
        <option value="<?= $kate['nama_kategori'] ?>" <?= $produk['kategori'] == $kate['nama_kategori'] ? 'selected' : '' ?>><?= $kate['nama_kategori'] ?></option>
      <?php endforeach ?>
    </select>
  </div>
  <div class="mb-4">
    <label class="block text-gray-700">Nama Barang</label>
    <input type="text" name="nama_produk" value="<?= $produk['nama_produk'] ?>" class="w-full p-2 border rounded border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
  </div>
  <div class="mb-4">
    <label class="block text-gray-700">Harga Beli</label>
    <div class="mt-1 relative rounded-md shadow-sm">
      <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
        <span class="text-gray-500">Rp</span>
      </div>
      <input type="number" name="harga_beli" value="<?= $produk['harga_beli'] ?>" class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" required>
    </div>
  </div>
  <div class="mb-4">
    <label class="block text-gray-700">Harga Jual*</label>
    <div class="mt-1 relative rounded-md shadow-sm">
      <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
        <span class="text-gray-500">Rp</span>
      </div>
      <input type="number" name="harga_jual" value="<?= $produk['harga_jual'] ?>" class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" required>
    </div>
  </div>
  <div class="mb-4 cols-12">
    <label class="block text-gray-700">Stok Barang</label>
    <input type="number" name="stok" value="<?= $produk['stok'] ?>" class="w-full p-2 border rounded border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" required placeholder="Masukkan jumlah stok barang">
  </div>

  <!-- Kolom Kanan (Gambar) -->
  <div class="mb-4 col-span-2">
    <label class="block text-gray-700">Upload Image</label>
    <div class="w-full border-2 border-dashed border-blue-400 rounded-lg p-4 text-center">
      <input type="file" accept=".jpg, .jpeg, .png" name="gambar" class="hidden" id="imageUpload">
      <label for="imageUpload" class="cursor-pointer">
        <div class="flex flex-col items-center">
          <svg class="w-12 h-12 text-blue-500 mb-2" fill="currentColor" viewBox="0 0 24 24">
            <path d="M19 11h-6V5h-2v6H5v2h6v6h2v-6h6z" />
          </svg>
          <span class="text-blue-500">upload gambar disini</span>
        </div>
      </label>
      <?php if ($produk['gambar']): ?>
        <p class="mt-2 text-gray-600">Gambar saat ini: <a href="<?= $produk['gambar'] ?>" target="_blank" class="text-blue-500 underline"><?= basename($produk['gambar']) ?></a></p>
      <?php endif ?>
    </div>
  </div>
</form>

<div class="flex justify-end mt-6 space-x-4">
  <button type="button" onclick="window.location.href = '<?= base_url('list-produk') ?>';" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">Batalkan</button>
  <button type="submit" form="produkForm" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
</div>

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

  const hargaBeliInput = document.querySelector('input[name="harga_beli"]');
  const hargaJualInput = document.querySelector('input[name="harga_jual"]');

  // Calculate selling price when buying price changes
  hargaBeliInput.addEventListener('input', calculateSellingPrice);

  function calculateSellingPrice() {
    const hargaBeli = parseFloat(hargaBeliInput.value) || 0;
    const markup = 0.3; // 30% markup
    const hargaJual = Math.round(hargaBeli * (1 + markup));

    hargaJualInput.value = hargaJual;
  }
</script>
<?= $this->endSection("script") ?>