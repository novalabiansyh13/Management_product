<?php

namespace Config;

$routes = Services::routes();
$this->auth = ['filter' => 'auth'];
$this->noauth = ['filter' => 'noauth'];
$this->akses = ['filter' => 'checkAccess'];

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

$routes->get('/', 'auth\LoginController::index', $this->noauth);
$routes->get('refreshcsrf', 'auth\LoginController::refreshCsrfCode');
$routes->group('login', function ($routes) {
    $routes->get('', 'auth\LoginController::index', $this->noauth);
    $routes->post('auth', 'auth\LoginController::auth', $this->noauth);
});
$routes->get('logout', 'auth\LoginController::logout');
$routes->get('welcome', 'View\Welcome::index', $this->auth);

// Product
$routes->group('products', function ($routes) {
    $routes->add('', 'Product::index', $this->akses);
    $routes->add('datatable', 'Product::datatable', $this->akses);
    $routes->add('form', 'Product::forms', $this->akses);
    $routes->add('edit/(:any)', 'Product::edit/$1', $this->akses);
    $routes->add('add', 'Product::add', $this->akses);
    $routes->add('update/(:any)', 'Product::update/$1', $this->akses);
    $routes->add('delete/(:any)', 'Product::delete/$1', $this->akses);
    $routes->add('categoryList', 'Product::categoryList', $this->akses);
    $routes->add('printPdf', 'Product::printPdf', $this->akses);
    $routes->add('exportExcel', 'Product::exportExcel', $this->akses);
    $routes->add('exportExcelChunk', 'Product::exportExcelChunk', $this->akses);
    $routes->add('exportExcelCount', 'Product::exportExcelCount', $this->akses);
    $routes->add('import', 'Product::import', $this->akses);
    $routes->add('importChunk', 'Product::importChunk', $this->akses);
    $routes->add('downloadTemplate', 'Product::downloadTemplate', $this->akses);
});

// Category
$routes->group('category', function ($routes) {
    $routes->add('', 'Category::index', $this->akses);
    $routes->add('datatable', 'Category::datatable', $this->akses);
    $routes->add('form', 'Category::forms', $this->akses);
    $routes->add('form/(:any)', 'Category::forms/$1', $this->akses);
    $routes->add('add', 'Category::add', $this->akses);
    $routes->add('update/(:any)', 'Category::update/$1', $this->akses);
    $routes->add('delete/(:any)', 'Category::delete/$1', $this->akses);
    $routes->add('printPdf', 'Category::printPdf', $this->akses);
});

/**
 * Setting Menu
 */
// Menu
$routes->group('menu', function ($routes) {
    $routes->add('', 'Menu::index', $this->akses);
    $routes->add('datatable', 'Menu::datatable', $this->akses);
    $routes->add('getMaster', 'Menu::getMaster', $this->auth);
    $routes->add('form', 'Menu::forms', $this->akses);
    $routes->add('form/(:any)', 'Menu::forms/$1', $this->akses);
    $routes->add('add', 'Menu::addMenu', $this->akses);
    $routes->add('update', 'Menu::updateMenu', $this->akses);
    $routes->add('delete', 'Menu::deleteMenu', $this->akses);
    $routes->add('sort', 'Menu::formSort', $this->akses);
    $routes->add('sortprocess', 'Menu::processSort', $this->akses);
});

// User Group
$routes->group('usergroup', function ($routes) {
    $routes->add('', 'Usergroup::index', $this->akses);
    $routes->add('datatable', 'Usergroup::datatable', $this->akses);
    $routes->add('form', 'Usergroup::forms', $this->akses);
    $routes->add('form/(:any)', 'Usergroup::forms/$1', $this->akses);
    $routes->add('add', 'Usergroup::addGroup', $this->akses);
    $routes->add('update', 'Usergroup::updateGroup', $this->akses);
    $routes->add('delete', 'Usergroup::deleteGroup', $this->akses);
    $routes->add('access/(:any)', 'Usergroup::accessView/$1', $this->akses);
    $routes->add('process_access', 'Usergroup::accessData', $this->akses);
    $routes->add('getgroup', 'Usergroup::getGroup', $this->auth);
});

// User
$routes->group('user', function ($routes) {
    $routes->add('', 'User::index', $this->akses);
    $routes->add('datatable', 'User::datatable', $this->akses);
    $routes->add('form', 'User::forms', $this->akses);
    $routes->add('form/(:any)', 'User::forms/$1', $this->akses);
    $routes->add('add', 'User::addUser', $this->akses);
    $routes->add('update', 'User::updateUser', $this->akses);
    $routes->add('delete', 'User::deleteUser', $this->akses);
    $routes->add('getuser', 'User::getUser', $this->auth);
    $routes->add('editactive', 'User::updateIsactive', $this->akses);
});

/**
 * Files Management
 */
$routes->group('files', function ($routes) {
    $routes->add('datatable', 'File::datatable', $this->akses);
    $routes->add('upload', 'File::upload', $this->akses);
    $routes->add('download/(:num)', 'File::download/$1', $this->akses);
    $routes->add('delete/(:num)', 'File::delete/$1', $this->akses);
    $routes->add('cleanup', 'File::cleanup', $this->akses);
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}