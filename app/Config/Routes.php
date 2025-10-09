<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'BookController::index');
$routes->get('books/filter', 'BookController::filter');
$routes->get('books/detail', 'BookController::detail');
$routes->post('books/add', 'BookController::add');
$routes->post('books/edit', 'BookController::edit');
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::attemptLogin');
$routes->get('logout', 'AuthController::logout');
$routes->get('peminjaman', 'TransactionController::peminjaman');