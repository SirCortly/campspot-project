<?php

use App\Domain\DateRange;
use App\Domain\Reservation;
use App\Domain\SchedulingRules\AlreadyReservedSchedulingRule;
use App\Domain\SchedulingRules\OneNightGapSchedulingRule;
use App\Services\SchedulingService;

class SchedulingServiceTest extends \PHPUnit\Framework\TestCase
{
    /*
     * @var App\Services\SchedulingService
     */
    protected $scheduling_service;

    public function setUp(): void
    {
        $this->scheduling_service = new SchedulingService();
    }

    public function testCanReservationBeMadeSucessful()
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

        $result = $this->scheduling_service->canReservationBeMade(
            $date_range,
            $reservations,
            [
                new AlreadyReservedSchedulingRule(),
                new OneNightGapSchedulingRule()
            ]
        );

        $this->assertTrue($result);
    }
}