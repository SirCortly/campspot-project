<?php
namespace App\Domain\SchedulingRules;

use App\Domain\Campsite;
use App\Domain\DateRange;
use App\Domain\Reservation;

class OneNightGapSchedulingRule implements SchedulingRule
{
    /**
     * @param DateRange $dateRange
     * @param Campsite $campsite
     * @param Reservation[] $reservations
     *
     * @return bool
     */
    public function check(DateRange $dateRange, array $reservations): bool
    {
        return true;
    }
}