<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'BookController::index');
$routes->get('books/filter', 'BookController::filter');
$routes->get('books/all', 'BookController::all');
$routes->get('books/detail', 'BookController::detail');
$routes->post('books/add', 'BookController::add');
$routes->post('books/edit', 'BookController::edit');
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::attemptLogin');
$routes->get('logout', 'AuthController::logout');
$routes->get('peminjaman', 'TransactionController::peminjaman');
$routes->post('books/upload-image', 'BookController::uploadImage');
$routes->get('api/analyze-image', 'ApiController::analyzeImage');
$routes->get('user', 'UserController::index');
$routes->get('test-firebase', 'FirebaseTest::index');

//CRUD
$routes->get('/buku', 'Buku::index');
$routes->post('/buku/add', 'Buku::add');
$routes->post('/buku/edit/(:any)', 'Buku::edit/$1');
$routes->post('/buku/delete', 'Buku::delete');
$routes->post('buku/importJson', 'Buku::importJson');