<?= $this->extend('dir_template/admin_panel') ?>
<?= $this->section("content") ?>

<div class="flex items-center mb-4">
  <div class="w-16 h-16 bg-gray-300 rounded-full overflow-hidden mr-4">
    <img src="<?= session()->get("data")->foto_profil ?: base_url('uploads/profil/blank-profile.webp') ?>" alt="Foto Profil" class="w-full h-full object-cover">
  </div>
  <div>
    <h2 class="text-xl font-bold"><?= session()->get("data")->full_name ?></h2>
  </div>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
  <div class="mb-4">
    <label class="block text-gray-700">Nama Kandidat</label>
    <div class="flex">
      <div class="px-4 py-2 bg-gray-100 text-black rounded-l-md">
        @
      </div>
      <input type="text" value="<?= session()->get("data")->full_name ?>" class="w-full p-2 border rounded-r-md bg-gray-100" readonly>
    </div>
  </div>
  <div class="mb-4">
    <label class="block text-gray-700">Posisi Kandidat</label>
    <div class="flex">
      <div class="px-4 py-2 bg-gray-100 text-black rounded-l-md">
        <\>
      </div>
      <input type="text" value="<?= session()->get("data")->posisi ?>" class="w-full p-2 border rounded-r-md bg-gray-100" readonly>
    </div>


  </div>
</div>

<?= $this->endSection("content") ?>

<?= $this->section("script") ?>

<?= $this->endSection("script") ?>