<?php
$uri = service('uri'); // Get url segment

$totalSegments = $uri->getTotalSegments();
$segmen1 = $uri->getSegment(1);
$segmen2 = $uri->getSegment(2);
$lastSegment = $uri->getSegment($totalSegments);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?=!empty($segmen1) ? ucwords(str_replace("-", " ", $lastSegment)) : ""?> | SIMS</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
  <!-- Tambahan script per halaman -->
  <?= $this->renderSection('head') ?>
</head>

<body class="bg-gray-100 min-h-screen flex">
  <!-- Mobile Toggle Button -->
  <button id="mobile-menu-toggle" class="fixed top-4 left-4 z-50 md:hidden">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
    </svg>
  </button>

  <!-- Sidebar Navigation -->
  <aside id="sidebar" class="fixed inset-y-0 left-0 transform -translate-x-full transition-transform duration-300 ease-in-out md:relative md:translate-x-0 w-64 bg-white shadow-md z-40">
    <div class="p-6 relative">
      <!-- Close Button for Mobile -->
      <button id="mobile-menu-close" class="absolute top-4 right-4 md:hidden">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>

      <h1 class="text-2xl font-bold text-primary mb-8 text-center">SIMS Web App</h1>
      <nav>
        <ul class="space-y-2">
          <li>
            <a href="<?= base_url("list-produk") ?>" class="flex items-center p-3 text-gray-700 hover:bg-gray-100 rounded <?= $segmen1 == "list-produk" ? "bg-blue-50" : "" ?>">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
              </svg>
              Products
            </a>
          </li>
          <li>
            <a href="<?= base_url("profil") ?>" class="flex items-center p-3 text-gray-700 hover:bg-gray-100 rounded <?= $segmen1 == "profil" ? "bg-blue-50" : "" ?>">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
              Profile
            </a>
          </li>
          <li>
            <a href="<?= base_url("logout") ?>" class="flex items-center p-3 text-red-500 hover:bg-red-50 rounded">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
              </svg>
              Logout
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <!-- Main Content Area -->
  <main class="flex-grow bg-gray-100 p-6 md:ml-0">
    <!-- Placeholder for content -->
    <div class="grid grid-cols-1">
      <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center space-x-2  mb-[20px] text-gray-500">
          <span class="text-gray-400 capitalize"><?=!empty($segmen1) ? str_replace("-", " ", $segmen1) : ""?></span>          
          <?php if(!empty($segmen2)):?>
            <span class="text-gray-400">›</span>
          <span class="font-semibold text-black capitalize"><?=str_replace("-", " ", $segmen2)?></span>
          <?php endif ?>
        </div>

        <!-- Content dinamis -->
        <?= $this->renderSection('content') ?>
      </div>
    </div>
  </main>

  <script>
    const sidebar = document.getElementById('sidebar');
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenuClose = document.getElementById('mobile-menu-close');

    mobileMenuToggle.addEventListener('click', () => {
      sidebar.classList.remove('-translate-x-full');
    });

    mobileMenuClose.addEventListener('click', () => {
      sidebar.classList.add('-translate-x-full');
    });
  </script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <!-- Tambahan script per halaman -->
  <?= $this->renderSection('script') ?>
</body>

</html>