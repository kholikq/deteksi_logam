<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');

// Rute untuk alat bantu generate hash
$routes->get('generate-hash/(:any)', 'HashGenerator::index/$1');

// Rute untuk API dari Arduino (tidak perlu filter login)
$routes->post('api/record', 'Api::record');

// Rute untuk Login & Logout
$routes->get('login', 'Login::index');
$routes->post('login/process', 'Login::process');
$routes->get('login/logout', 'Login::logout');

// Rute untuk aplikasi web yang dilindungi (gunakan filter 'auth')
$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'Dashboard::index');
    $routes->get('dashboard/full-report', 'Dashboard::fullReport');
    $routes->get('dashboard/print-report', 'Dashboard::printReport'); // [PERUBAHAN] Rute baru untuk cetak
    $routes->get('dashboard/get-realtime-data', 'Dashboard::getRealtimeData');
    
    // Rute untuk Manajemen Pengguna (hanya untuk admin, dihandle di controller)
    $routes->get('users', 'UserManagement::index');
    $routes->post('users/save', 'UserManagement::save');
    $routes->get('users/delete/(:num)', 'UserManagement::delete/$1');
});
