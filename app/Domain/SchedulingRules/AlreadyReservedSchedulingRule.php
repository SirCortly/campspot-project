<?php

namespace App\Domain\SchedulingRules;

use App\Domain\DateRange;
use App\Domain\Reservation;

class AlreadyReservedSchedulingRule implements SchedulingRule
{
    public function check(DateRange $dateRange, array $reservations): bool
    {
        return true;
    }
}