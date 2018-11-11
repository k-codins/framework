<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFromGlobals();
$response = new Response;

$map = [
    '/hello' => '/../src/pages/hello.php',
    '/bye' => '/../src/pages/bye.php'
];

$pathInfo = $request->getPathInfo();

if (isset($map[$pathInfo])) {
    ob_start();
    include __DIR__ . $map[$pathInfo];
    $response->setContent(ob_get_clean());
}
else {
    $response->setStatusCode(404);
    $response->setContent('Not found');
}

$response->send();
