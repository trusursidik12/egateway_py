<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->add('/changepassword', 'Home::changepassword');

$routes->add('/login', 'A_login::index');
$routes->add('/logout', 'A_login::logout');

$routes->get('/users', 'A_user::index');
$routes->add('/user/add', 'A_user::add');
$routes->add('/user/edit/(:num)', 'A_user::edit/$1');
$routes->add('/user/delete/(:num)', 'A_user::delete/$1');
$routes->add('/user/profile', 'A_user::profile');

$routes->get('/groups', 'A_group::index');
$routes->add('/group/add', 'A_group::add');
$routes->add('/group/edit/(:num)', 'A_group::edit/$1');
$routes->add('/group/delete/(:num)', 'A_group::delete/$1');

$routes->get('/menu', 'A_menu::index');
$routes->add('/menu/add/', 'A_menu::add/$1');
$routes->add('/menu/edit/(:num)', 'A_menu::edit/$1');
$routes->add('/menu/delete/(:num)', 'A_menu::delete/$1');
// Instruments
$routes->get('/instruments', 'Instrument::index');
// Stakcs
$routes->get('/stacks', 'Stack::index');
// Parameter
$routes->get('/parameters', 'Parameter::index');
// Configurations
$routes->get('/configurations', 'Configuration::index');
// Sispek
$routes->get('/sispeks', 'Sispek::index');
$routes->post('/sispek/edit/(:num)', 'Sispek::update/$1');
// LABJACKS
$routes->get('/labjacks', 'Labjack::index');
$routes->get('/labjack/add', 'Labjack::add');
$routes->add('/labjack/edit/(:num)', 'Labjack::edit/$1');
$routes->add('/process/labjack/delete', 'Labjack::delete');
//
$routes->get('/dis_data', 'Measurement::index');
$routes->add('/measurement/list', 'Measurement::getList');
$routes->get('/das_logs', 'Das_log::index');
$routes->add('/das_log/list', 'Das_log::getList');

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
