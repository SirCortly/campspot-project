<?php
namespace App\Services;

use App\Domain\Campsite;
use App\Domain\DateRange;
use App\Domain\Reservation;
use App\SchedulingRules\SchedulingRule;

class SchedulingService
{
    /**
     * Check whether campsite is available to book for given date range and scheduling rules
     *
     * @param DateRange $date_range
     * @param Campsite $campsite
     * @param Reservation[] $reservations
     * @param SchedulingRule[] $schedulingRules
     *
     * @return bool
     */
    public function isCampsiteAvailable(
        DateRange $date_range,
        Campsite $campsite,
        array $reservations,
        array $schedulingRules
    ): bool {

    }
}