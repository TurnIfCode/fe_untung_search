<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'SearchController::index');
$routes->get('search', 'SearchController::index');
$routes->post('search', 'SearchController::index');
