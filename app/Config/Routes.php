<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
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
$routes->set404Override(function(){echo json_encode(['error' => '404 - Método API não encontrado.']);});
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

//HOME ROUTER ------------------------------------------------------
//------------------------------------------------------------------
$routes->get('/', 'Home::index');

//AUTH ROUTER ------------------------------------------------------
//------------------------------------------------------------------

$routes->get('auth/','');
$routes->post('auth/','Auth::index');

//ARTISTA ROUTER ---------------------------------------------------
//------------------------------------------------------------------

//BUSCAR TODOS
$routes->get('artista/','Artista::show/all');
$routes->get('artista/asc/','Artista::show/all/asc');
$routes->get('artista/desc/','Artista::show/all/desc');

//BUSCAR POR ID
$routes->get('artista/id/(:num)','Artista::show/id/$1');

//BUSCAR POR NOME
$routes->post('artista/buscar/','Artista::show/search');
$routes->post('artista/buscar/asc/','Artista::show/search/asc');
$routes->post('artista/buscar/desc/','Artista::show/search/desc');

//ADD NOVO
$routes->post('artista/','Artista::show/add');

//EDITAR
$routes->put('artista/','Artista::show/edit');

//DELETAR
$routes->delete('artista/','Artista::show/delete');

//ALBUM ROUTER -----------------------------------------------------
//------------------------------------------------------------------

//BUSCAR TODOS
$routes->get('album/','Album::show/all');
$routes->get('album/asc/','Album::show/all/asc');
$routes->get('album/desc/','Album::show/all/desc');

//BUSCAR POR ID
$routes->get('album/id/(:num)','Album::show/id/$1');

//BUSCAR POR NOME
$routes->post('album/buscar/','Album::show/search');
$routes->post('album/buscar/asc/','Album::show/search/asc');
$routes->post('album/buscar/desc/','Album::show/search/desc');

//ADD NOVO
$routes->post('album/','Album::show/add');

//EDITAR
$routes->put('album/','Album::show/edit');

//DELETAR
$routes->delete('album/','Album::show/delete');
/**
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
