<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Client\Auth::index');
$routes->post('login', 'Client\Auth::login');
$routes->get('logout', 'Client\Auth::logout');
$routes->get('dashboard', 'Client\Operation::dashboard');
