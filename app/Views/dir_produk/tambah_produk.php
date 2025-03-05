<?= $this->extend('dir_template/admin_panel') ?>
<?= $this->section("content") ?>
<h2 class="text-2xl font-bold mb-4 text-center">Tambah Produk Baru</h2>

<form id="produkForm" enctype="multipart/form-data">
  <div class="space-y-6">
    <div class="grid grid-cols-2 gap-4">
      <!-- Kategori -->
      <div>
        <label class="text-sm font-medium text-gray-700">Kategori</label>
        <select id="kategori" name="kategori" class="mt-1 w-full px-4 py-3 bg-white rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" required>
          <option value="">Semua</option>
          <?php foreach ($katego as $barang): ?>
            <option value="<?= $barang["nama_kategori"] ?>"><?= $barang["nama_kategori"] ?></option>
          <?php endforeach ?>
        </select>
      </div>
      <!-- Nama Produk -->
      <div>
        <label class="text-sm font-medium text-gray-700">Nama Produk</label>
        <input type="text" name="nama_produk" class="mt-1 w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" required>
      </div>
    </div>

    <!-- Harga -->
    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="text-sm font-medium text-gray-700">Harga Beli</label>
        <div class="mt-1 relative rounded-md shadow-sm">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <span class="text-gray-500">Rp</span>
          </div>
          <input type="number" name="harga_beli" class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" required>
        </div>
      </div>

      <div>
        <label class="text-sm font-medium text-gray-700">Harga Jual</label>
        <div class="mt-1 relative rounded-md shadow-sm">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <span class="text-gray-500">Rp</span>
          </div>
          <input type="number" name="harga_jual" class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" required>
        </div>
      </div>
    </div>

    <!-- Stok -->
    <div>
      <label class="text-sm block font-medium text-gray-700">Stok</label>
      <input type="number" name="stok" class="mt-1 w-[49%] px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" required>
    </div>

    <!-- Gambar upload dengan preview -->
    <div>
      <label class="text-sm font-medium text-gray-700">Gambar Produk</label>
      <div class="mt-1 w-full">
        <div id="imagePreviewContainer" class="hidden mb-3 relative w-full h-64 rounded-lg border-2 border-dashed border-gray-300 flex justify-center items-center overflow-hidden">
          <img id="imagePreview" class="max-h-full max-w-full object-contain" src="#" alt="Preview">
          <button type="button" id="removeImage" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
          </button>
        </div>

        <div id="uploadContainer" class="w-full h-32 rounded-lg border-2 border-dashed border-gray-300 flex flex-col justify-center items-center cursor-pointer hover:bg-gray-50 transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
          <p class="mt-2 text-sm text-gray-500">Klik untuk upload atau drag & drop</p>
          <p class="text-xs text-gray-400">JPG, JPEG, PNG</p>
        </div>

        <input type="file" name="gambar" id="imageInput" accept=".jpg, .jpeg, .png" class="hidden">
      </div>
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

    fetch('<?= base_url('api/tambah-produk') ?>', {
        method: 'POST',
        headers: {
          'Authorization': 'Bearer <?= session()->get('jwt_token') ?>'
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
<script>
  // Image preview functionality
  const imageInput = document.getElementById('imageInput');
  const uploadContainer = document.getElementById('uploadContainer');
  const imagePreview = document.getElementById('imagePreview');
  const imagePreviewContainer = document.getElementById('imagePreviewContainer');
  const removeImage = document.getElementById('removeImage');

  uploadContainer.addEventListener('click', () => {
    imageInput.click();
  });

  uploadContainer.addEventListener('dragover', (e) => {
    e.preventDefault();
    uploadContainer.classList.add('border-blue-500');
  });

  uploadContainer.addEventListener('dragleave', () => {
    uploadContainer.classList.remove('border-blue-500');
  });

  uploadContainer.addEventListener('drop', (e) => {
    e.preventDefault();
    uploadContainer.classList.remove('border-blue-500');
    if (e.dataTransfer.files.length) {
      imageInput.files = e.dataTransfer.files;
      showPreview();
    }
  });

  imageInput.addEventListener('change', showPreview);

  function showPreview() {
    if (imageInput.files && imageInput.files[0]) {
      const reader = new FileReader();

      reader.onload = (e) => {
        imagePreview.src = e.target.result;
        imagePreviewContainer.classList.remove('hidden');
        uploadContainer.classList.add('hidden');
      };

      reader.readAsDataURL(imageInput.files[0]);
    }
  }

  removeImage.addEventListener('click', () => {
    imageInput.value = '';
    imagePreviewContainer.classList.add('hidden');
    uploadContainer.classList.remove('hidden');
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