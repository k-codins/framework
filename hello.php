<?php

require_once __DIR__ . '/front.php';

$name = $request->get('name', 'Pretty');

$response = $response->setContent(str_replace('%s', htmlspecialchars($name, ENT_QUOTES), 'Have a good day, %s'));
