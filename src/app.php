<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();
$routes->add('hello', new Route('/hello/{name}', ['name' => 'Fabien']));
$routes->add('bye', new Route('/bye'));

return $routes;
