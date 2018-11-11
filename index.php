<?php

require_once 'vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFromGlobals();

$name = $request->get('name', 'Pretty');

$response = new Response(str_replace('%s', htmlspecialchars($name, ENT_QUOTES), 'Have a good day, %s'));

$response->send();
