<?= $this->extend('dir_template/admin_panel') ?>
<?= $this->section("head") ?>
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<style>
  .force-right{
    position: absolute !important;
    float: right;
    right: 0px;
    top: -45px;
    background-color: green !important;
    color: #eff !important;
    border-radius: 4px !important;
    border: none !important;
  }
  table.w-full{width:100% !important}
</style>
<?= $this->endSection() ?>

<?= $this->section("content") ?>
<h2 class="text-2xl font-bold mb-4">Daftar Produk</h2>
<a href="<?= base_url('list-produk/tambah-produk') ?>" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Tambah Produk</a>

<div class="pb-1">
  <input type="text" id="globalSearch" placeholder="Cari baranng" class="py-2 px-3 border">
  <select id="filterOffice" class="py-2 px-3 border">
    <option value="">Semua</option>
    <?php foreach($katego as $barang):?>
    <option value="<?=$barang["nama_kategori"]?>"><?=$barang["nama_kategori"]?></option>
    <?php endforeach ?>
  </select>
</div>
<table id="dataProduk" class="w-full bg-white shadow-md rounded">
  <thead>
    <tr class="bg-gray-200">
      <th class="p-3 text-left">No.</th>
      <th class="p-3 text-left">Gambar</th>
      <th class="p-3 text-left">Nama Produk</th>
      <th class="p-3 text-left">Kategori</th>
      <th class="p-3 text-left">Harga Beli (Rp.)</th>
      <th class="p-3 text-left">Harga Jual (Rp.)</th>
      <th class="p-3 text-left">Stok Produk</th>
      <th class="p-3 text-left">Aksi</th>
    </tr>
  </thead>
  <tbody id="produkTable">
    <tr id="loader">
      <td colspan="8" class="">
        <div class="flex justify-center items-center h-20">
          <div class="w-10 h-10 border-4 border-gray-300 border-t-blue-500 rounded-full animate-spin"></div>
        </div>
      </td>
    </tr>
  </tbody>
</table>

<!-- Modal Konfirmasi -->
<div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
  <div class="bg-white p-6 rounded-lg shadow-lg w-96">
    <h3 class="text-lg font-bold mb-4">Konfirmasi Hapus</h3>
    <p class="mb-4">Yakin ingin menghapus produk ini?</p>
    <div class="flex justify-end">
      <button id="cancelDelete" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Batal</button>
      <button id="confirmDelete" class="bg-red-500 text-white px-4 py-2 rounded">Hapus</button>
    </div>
  </div>
</div>

<?= $this->endSection("content") ?>

<?= $this->section("script") ?>
<script>
  $(document).ready(function() {
    fetch('<?= base_url('api/get-all-produk') ?>', {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': 'Bearer <?= session()->get('jwt_token') ?>'
        }
      })
      .then(response => response.json())
      .then(produkData => {
        if (produkData.status === 200) {

          var table = $('#dataProduk').DataTable({
            dom: 'Brtip', // Menampilkan tombol export
            buttons: [{
              extend: 'excel',
              text: '🗎 Export Excel', // Tombol dengan ikon
              className: 'force-right' // Tambahkan class styling
            }],
            "ordering": false,
            data: produkData.data,
            columns: [{
                data: null,
                render: (data, type, row, meta) => meta.row + 1
              }, // Nomor urut
              {
                data: "gambar",
                render: gambar => `
                              <img src="${gambar}" class="h-10 w-10 object-cover">
                `
              },
              {
                data: "nama_produk"
              },
              {
                data: "kategori"
              },
              {
                data: "harga_beli",
                render: data => `Rp ${data.toLocaleString()}`
              },
              {
                data: "harga_jual",
                render: data => `Rp ${data.toLocaleString()}`
              },
              {
                data: "stok"
              },
              {
                data: "produk_id",
                render: id => `
                            <a href="<?= base_url('list-produk/update-produk') ?>/${id}">Edit</a>
                            <button onclick="showDeleteModal(${id})" class="text-red-500 hover:underline ml-2">Hapus</button>
                        `
              } // Tombol Edit & Hapus
            ]
          });

          // Custom search global
          $('#globalSearch').on('keyup', function() {
            table.search(this.value).draw();
          })

          // Custom filter dengan dropdown
          $('#filterOffice').on('change', function() {
            table.column(3).search(this.value).draw();
          });

          // let html = '';
          // data.data.forEach(produk => {
          //   html += `
          //         <tr>
          //             <td class="p-3">${produk.produk_id}</td>
          //             <td class="p-3">${produk.gambar ? `<img src="${produk.gambar}" class="h-10 w-10 object-cover">` : 'Tidak ada'}</td>
          //             <td class="p-3">${produk.nama_produk}</td>
          //             <td class="p-3">${produk.kategori}</td>
          //             <td class="p-3">${produk.harga_beli}</td>
          //             <td class="p-3">${produk.harga_jual}</td>
          //             <td class="p-3">${produk.stok}</td><td class="p-3">
          //               <a href="<?= base_url('list-produk/update-produk') ?>/${produk.produk_id}">Edit</a>
          //               <button onclick="showDeleteModal(${produk.produk_id})" class="text-red-500 hover:underline ml-2">Hapus</button>
          //             </td>
          //         </tr>
          //     `;
          // });
          // $('#produkTable').html(html);
        } else {
          toastr.error('Gagal mengambil data produk.');
        }
      })
      .catch(error => {
        toastr.error('Terjadi kesalahan: ' + error);
      });

    let selectedProdukId = null;

    window.showDeleteModal = function(produk_id) {
      selectedProdukId = produk_id;
      $('#deleteModal').removeClass('hidden');
    };

    $('#cancelDelete').click(function() {
      $('#deleteModal').addClass('hidden');
      selectedProdukId = null;
    });

    $('#confirmDelete').click(function() {
      if (selectedProdukId) {
        fetch('<?= base_url('api/delete-produk/') ?>' + selectedProdukId, {
            method: 'DELETE',
            headers: {
              'Authorization': 'Bearer <?= session()->get('jwt_token') ?>',
              'Content-Type': 'application/json'
            }
          })
          .then(response => response.json())
          .then(data => {
            if (data.status === 200) {
              toastr.success(data.message);
              $('#deleteModal').addClass('hidden');
              setTimeout(() => location.reload(), 1000);
            } else {
              toastr.error(data.message);
            }
          })
          .catch(error => toastr.error('Terjadi kesalahan: ' + error));
      }
    });

  });
</script>

<!-- Library Datatables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- DataTables Buttons -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<!-- JSZip (Wajib untuk export Excel) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<!-- <script>
  $(document).ready(function() {
    $('#dataProduk').DataTable({
      dom: 'Bfrtip', // Menampilkan tombol export
      buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
      ]
    });
  });
</script> -->

<?= $this->endSection("script") ?>