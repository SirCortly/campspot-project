<?php
namespace App\Domain\SchedulingRules;

use App\Domain\Campsite;
use App\Domain\DateRange;
use App\Domain\Reservation;

interface SchedulingRule
{
    /**
     * @param DateRange $dateRange
     * @param Reservation[] $reservations
     *
     * @return bool
     */
    public function check(DateRange $dateRange, array $reservations): bool;
}