<?php
namespace App\Services;

use App\Domain\Campsite;
use App\Domain\DateRange;
use App\Domain\Reservation;
use App\Domain\SchedulingRules\SchedulingRule;

class SchedulingService
{
    /**
     * Check whether campsite is available to book for given date range and scheduling rules
     *
     * @param DateRange $date_range
     * @param Reservation[] $reservations
     * @param SchedulingRule[] $schedulingRules
     *
     * @return bool
     */
    public function canReservationBeMade(
        DateRange $date_range,
        array $reservations,
        array $schedulingRules
    ): bool {
        foreach ($schedulingRules as $schedulingRule) {
            if (!$schedulingRule->check($date_range, $reservations)) {
                return false;
            }
        }

        return true;
    }
}