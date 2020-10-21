<?php

use App\Domain\DateRange;
use App\Domain\Reservation;
use App\Domain\SchedulingRules\AlreadyReservedSchedulingRule;

class AlreadyReservedSchedulingRuleTest extends \PHPUnit\Framework\TestCase
{
    protected $already_reserved_scheduling_rule;

    public function setUp(): void
    {
        $this->already_reserved_scheduling_rule = new AlreadyReservedSchedulingRule();
    }

    public function testCheckSuccessful()
    {
        $reservation_one = new Reservation(
            101,
            new DateRange(new DateTime('2020-01-01'), new DateTime('2020-01-05'))
        );

        $reservation_two = new Reservation(
            101,
            new DateRange(new DateTime('2020-01-10'), new DateTime('2020-01-15'))
        );

        $start_date = new DateTime('2020-01-06');
        $end_date = new DateTime('2020-01-09');

        $date_range = new DateRange($start_date, $end_date);
        $reservations = [$reservation_one, $reservation_two];

        $result = $this->already_reserved_scheduling_rule->check($date_range, $reservations);

        $this->assertTrue($result);
    }

    public function testCheckFailureStartDateAlreadyReserved()
    {
        $reservation = new Reservation(
            101,
            new DateRange(new DateTime('2020-01-01'), new DateTime('2020-01-05'))
        );

        $start_date = new DateTime('2020-01-04');
        $end_date = new DateTime('2020-01-09');

        $date_range = new DateRange($start_date, $end_date);
        $reservations = [$reservation];

        $result = $this->already_reserved_scheduling_rule->check($date_range, $reservations);

        $this->assertFalse($result);
    }

    public function testCheckFailureEndDateAlreadyReserved()
    {
        $reservation = new Reservation(
            101,
            new DateRange(new DateTime('2020-01-10'), new DateTime('2020-01-15'))
        );

        $start_date = new DateTime('2020-01-06');
        $end_date = new DateTime('2020-01-11');

        $date_range = new DateRange($start_date, $end_date);
        $reservations = [$reservation];

        $result = $this->already_reserved_scheduling_rule->check($date_range, $reservations);

        $this->assertFalse($result);
    }

    public function testCheckFailureReservationOccursBetweenStartAndEndDates()
    {
        $reservation = new Reservation(
            101,
            new DateRange(new DateTime('2020-01-05'), new DateTime('2020-01-08'))
        );

        $start_date = new DateTime('2020-01-01');
        $end_date = new DateTime('2020-01-10');

        $date_range = new DateRange($start_date, $end_date);
        $reservations = [$reservation];

        $result = $this->already_reserved_scheduling_rule->check($date_range, $reservations);

        $this->assertFalse($result);
    }
}