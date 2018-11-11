<?php

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

function is_leap_year($year = null)
{
    if (is_null($year)) {
        $year = date('Y');
    }

    return 0 === $year % 400 || (0 === $year && 0 !== $year % 100);
}

$routes = new RouteCollection();
$routes->add('is_leap_year', new Route('/is_leap_year/{year}', [
    'year' => null,
    '_controller' => 'LeapYearController::index']));

return $routes;

class LeapYearController
{
    public function index($year = 2012)
    {
        if (is_leap_year($year)) {
            return new Response('Yes, this is a leap year!');
        }
        return new Response('Nope, this is not a leap year!');
    }
}
