<?php
namespace App\SchedulingRules;

interface SchedulingRule
{
    /**
     * @param DateRange $dateRange
     * @param Campsite $campsite
     * @param Reservation[] $reservations
     *
     * @return bool
     */
    public function check(DateRange $dateRange, Campsite $campsite, array $reservations): bool;
}