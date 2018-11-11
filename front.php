<?php

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFromGlobals();
$response = new Response;

$map = [
    '/hello' => '/hello.php',
    '/bye' => '/bye.php'
];

$pathInfo = $request->getPathInfo();

if (isset($map[$pathInfo])) {
    include_once __DIR__ . $map[$pathInfo];
}
else {
    $response->setStatusCode(404);
    $response->setContent('Not found');
}

$response->send();
