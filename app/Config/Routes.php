<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');
$routes->get('/login', 'Home::login');

$routes->get('/start-session', 'Home::startSession');

$routes->get('/list-produk', 'Frontend\PanelController::listProduk');
$routes->get('/profil', 'Frontend\PanelController::profil');
$routes->get('/list-produk/tambah-produk', 'Frontend\PanelController::tambahProduk');
$routes->get('/list-produk/update-produk/(:num)', 'Frontend\PanelController::updateProduk/$1');


$routes->post('api/login', 'Backend\AuthController::login');
$routes->group('api', ['filter' => 'jwt'], function ($routes) {
  $routes->get('get-all-produk', 'Backend\ApiProdukController::index');
  $routes->post('tambah-produk', 'Backend\ApiProdukController::create');
  $routes->post('update-produk/(:num)', 'Backend\ApiProdukController::update/$1');
  $routes->delete('delete-produk/(:num)', 'Backend\ApiProdukController::delete/$1');
  // Route yang dilindungi JWT
  // Contoh: $routes->get('profile', 'ProfileController::index');
});
