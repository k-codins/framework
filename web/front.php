<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;


$request = Request::createFromGlobals();
$response = new Response;

$routes = include_once __DIR__ . '/../src/app.php';

$context = new RequestContext();
$context->fromRequest($request);
$matcher = new UrlMatcher($routes, $context);

$path = $request->getPathInfo();

try {
    extract($matcher->match($request->getPathInfo()), EXTR_SKIP);
    ob_start();
    include sprintf(__DIR__ . '/../src/pages/%s.php', $_route);
    $response->setContent(ob_get_clean());
} catch (ResourceNotFoundException $exception) {
    $response->setContent('Not found', 404);
} catch (Exception $exception) {
    $response->setContent('An error occured', 500);
}

$generator = new UrlGenerator($routes, $context);
$generator->generate('hello', ['name' => 'Robin']);

$response->send();
