<?php

namespace App\Domain\SchedulingRules;

use App\Domain\DateRange;
use App\Domain\Reservation;
use DateTime;

class AlreadyReservedSchedulingRule implements SchedulingRule
{
    /**
     * @param DateRange $date_range
     * @param Reservation[] $reservations
     *
     * @return bool
     */
    public function check(DateRange $date_range, array $reservations): bool
    {
        foreach ($reservations as $reservation) {
            // Check that start date doesn't overlap with reservation
            if ($this->isDateBetweenDates($date_range->getStartDate(), $reservation->getDateRange())){
                return false;
            }
            // Check that end date doesn't overlap with reservation
            if ($this->isDateBetweenDates($date_range->getEndDate(), $reservation->getDateRange())){
                return false;
            }
            // Check that reservation does not occur within date range
            if ($this->isDateBetweenDates($reservation->getDateRange()->getStartDate(), $date_range) &&
                $this->isDateBetweenDates($reservation->getDateRange()->getEndDate(), $date_range)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check whether a date falls within a date range
     *
     * @param DateTime $date
     * @param DateRange $date_range
     *
     * @return bool
     */
    private function isDateBetweenDates(DateTime $date, DateRange $date_range): bool
    {
        return $date >= $date_range->getStartDate() && $date <= $date_range->getEndDate();
    }
}