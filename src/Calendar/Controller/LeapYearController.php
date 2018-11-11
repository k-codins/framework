<?php

namespace Calendar\Controller;

use Calendar\Model\LeapYear;
use Symfony\Component\HttpFoundation\Response;

class LeapYearController
{
    public function index($year = 2012)
    {
        $leap_year = new LeapYear();
        if ($leap_year->is_leap_year($year)) {
            return new Response('Yes, this is a leap year!');
        }
        return new Response('Nope, this is not a leap year!');
    }
}
