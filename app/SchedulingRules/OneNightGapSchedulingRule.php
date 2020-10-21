<?php
namespace App\SchedulingRules;

class OneNightGapSchedulingRule implements SchedulingRule
{
    public function check(DateRange $dateRange, Campsite $campsite, array $reservations): bool
    {
        return true;
    }
}