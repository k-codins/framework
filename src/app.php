<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();
$routes->add('hello', new Route('/hello/{name}', [
    'name' => 'Fabien',
    '_controller' => function ($request) {
        $response = render_template($request);
        $response->headers->set('Content-Type', 'text/plain');
        return $response;
    }
]));
$routes->add('bye', new Route('/bye'));

return $routes;
