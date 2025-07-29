<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Login::index');
$routes->get('generate-hash/(:any)', 'HashGenerator::index/$1');
$routes->match(['get', 'post'], 'api/record', 'Api::record');
$routes->get('login', 'Login::index');
$routes->post('login/process', 'Login::process');
$routes->get('login/logout', 'Login::logout');

$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'Dashboard::index');
    $routes->post('dashboard/start', 'Dashboard::startProduction');
    $routes->get('dashboard/finish/(:num)', 'Dashboard::finishProduction/$1');
    $routes->get('dashboard/get-realtime-data', 'Dashboard::getRealtimeData');
    $routes->get('dashboard/full-report', 'Dashboard::fullReport');
    // [PERUBAHAN] Rute baru untuk export
    $routes->get('dashboard/export-pdf', 'Dashboard::exportPDF');
    $routes->get('dashboard/export-excel', 'Dashboard::exportExcel');
    
    // Rute untuk Manajemen Pengguna
    $routes->get('users', 'UserManagement::index');
    $routes->post('users/save', 'UserManagement::save');
    $routes->get('users/delete/(:num)', 'UserManagement::delete/$1');

    // Rute untuk Manajemen Varian Roti
    $routes->get('varian-roti', 'VarianRoti::index');
    $routes->post('varian-roti/save', 'VarianRoti::save');
    $routes->get('varian-roti/delete/(:num)', 'VarianRoti::delete/$1');
});
