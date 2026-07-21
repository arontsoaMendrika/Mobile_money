<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Client\Auth::index');
$routes->post('login', 'Client\Auth::login');
$routes->get('logout', 'Client\Auth::logout');
$routes->get('dashboard', 'Client\Operation::dashboard');
$routes->get('retrait', 'Client\Operation::retraitForm');
$routes->post('retrait', 'Client\Operation::retrait');
$routes->get('depot', 'Client\Operation::formulaireDepot');
$routes->post('depot', 'Client\Operation::depot');
$routes->get('transfert', 'Client\Operation::formulaireTransfert');
$routes->post('transfert', 'Client\Operation::transfert');
$routes->group('admin', function($routes) {
    $routes->get('/', static fn() => redirect()->to('admin/dashboard'));
    $routes->get('prefixes', 'Admin\Config::prefixes');
    $routes->post('prefixes', 'Admin\Config::savePrefixes');
    $routes->get('baremes', 'Admin\Config::baremes');
    $routes->post('baremes/add', 'Admin\Config::addBareme');
    $routes->get('baremes/delete/(:num)', 'Admin\Config::deleteBareme/$1');
    $routes->get('dashboard', 'Admin\Dashboard::index');
    $routes->get('operateurs', 'Admin\Operateurs::index');
    $routes->post('operateurs/add', 'Admin\Operateurs::addOperateur');
    $routes->post('operateurs/update/(:num)', 'Admin\Operateurs::updateOperateur/$1');
    $routes->post('prefixe/add', 'Admin\Operateurs::addPrefixe');
    $routes->get('prefixe/delete/(:num)', 'Admin\Operateurs::deletePrefixe/$1');
    $routes->get('reversements', 'Admin\Rapport::reversements');
});
$routes->post('epargner', 'Client\Operation::epargner');