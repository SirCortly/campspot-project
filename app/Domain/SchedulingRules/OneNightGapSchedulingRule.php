<?php
namespace App\Domain\SchedulingRules;

use App\Domain\DateRange;
use App\Domain\Reservation;
use DateTime;

class OneNightGapSchedulingRule implements SchedulingRule
{
    const DAYS_APART_TO_CREATE_ONE_DAY_GAP = 2;

    /**
     * @param DateRange $dateRange
     * @param Reservation[] $reservations
     *
     * @return bool
     */
    public function check(DateRange $dateRange, array $reservations): bool
    {
        foreach ($reservations as $reservation) {
            if ($this->getDaysBetweenDates($dateRange->getStartDate(), $reservation->getDateRange()->getEndDate()) ===
                self::DAYS_APART_TO_CREATE_ONE_DAY_GAP) {
                return false;
            }
            if ($this->getDaysBetweenDates($dateRange->getEndDate(), $reservation->getDateRange()->getStartDate()) ===
                self::DAYS_APART_TO_CREATE_ONE_DAY_GAP) {
                return false;
            }
        }

        return true;
    }

    private function getDaysBetweenDates(DateTime $dateTimeOne, DateTime $dateTimeTwo): int
    {
        if ($dateTimeOne < $dateTimeTwo) {
            $interval = $dateTimeOne->diff($dateTimeTwo);
        } else {
            $interval = $dateTimeTwo->diff($dateTimeOne);
        }

        return $interval->format("%a");
    }
}