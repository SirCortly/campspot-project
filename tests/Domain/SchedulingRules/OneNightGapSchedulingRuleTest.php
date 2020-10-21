<?php

use App\Domain\DateRange;
use App\Domain\Reservation;
use App\Domain\SchedulingRules\OneNightGapSchedulingRule;

class OneNightGapSchedulingRuleTest extends \PHPUnit\Framework\TestCase
{
    protected $one_night_gap_scheduling_rule;

    public function setUp(): void
    {
        $this->one_night_gap_scheduling_rule = new OneNightGapSchedulingRule();
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

        $result = $this->one_night_gap_scheduling_rule->check($date_range, $reservations);

        $this->assertTrue($result);
    }

    public function testCheckFailureGapBetweenStartDate()
    {
        $reservation = new Reservation(
            101,
            new DateRange(new DateTime('2020-01-01'), new DateTime('2020-01-05'))
        );

        $start_date = new DateTime('2020-01-07');
        $end_date = new DateTime('2020-01-09');

        $date_range = new DateRange($start_date, $end_date);
        $reservations = [$reservation];

        $result = $this->one_night_gap_scheduling_rule->check($date_range, $reservations);

        $this->assertFalse($result);
    }

    public function testCheckFailureGapBetweenEndDate()
    {
        $reservation = new Reservation(
            101,
            new DateRange(new DateTime('2020-01-10'), new DateTime('2020-01-15'))
        );

        $start_date = new DateTime('2020-01-06');
        $end_date = new DateTime('2020-01-08');

        $date_range = new DateRange($start_date, $end_date);
        $reservations = [$reservation];

        $result = $this->one_night_gap_scheduling_rule->check($date_range, $reservations);

        $this->assertFalse($result);
    }
}