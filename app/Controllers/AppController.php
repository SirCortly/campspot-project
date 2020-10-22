<?php
namespace App\Controllers;

use App\Domain\Campsite;
use App\Domain\DateRange;
use App\Domain\Reservation;
use App\Domain\SchedulingRules\AlreadyReservedSchedulingRule;
use App\Domain\SchedulingRules\OneNightGapSchedulingRule;
use App\Domain\SchedulingRules\SchedulingRule;
use App\Services\SchedulingService;

class AppController
{
    /*
     * @var App\Services\SchedulingService
     */
    protected $scheduling_service;

    public function __construct(SchedulingService $scheduling_service)
    {
        $this->scheduling_service = $scheduling_service;
    }

    /**
     * Check available campsites from json input and output results
     *
     * @param $json_data
     */
    public function handle($json_data): void
    {
        $date_range = $this->getDateRangeFromJsonData($json_data);
        $campsites = $this->getCampsitesFromJsonData($json_data);

        $availableCampsites = [];
        foreach ($campsites as $campsite) {
            $reservations = $this->getReservationsForCampsiteFromJsonData($campsite, $json_data);
            if ($this->scheduling_service->canReservationBeMade($date_range, $reservations, $this->getSchedulingRules())) {
                $availableCampsites[] = $campsite;
            }
        }

        foreach ($availableCampsites as $availableCampsite) {
            echo '"' . $availableCampsite->getName() . '"\n';
        }
    }

    /**
     * Create DateRange object from json data
     *
     * @param $json_data
     *
     * @return DateRange
     * @throws \Exception
     */
    private function getDateRangeFromJsonData($json_data): DateRange
    {
        $start_date = new \DateTime($json_data->search->startDate);
        $end_date = new \DateTime($json_data->search->endDate);

        return new DateRange($start_date, $end_date);
    }

    /**
     * Create Campsite array from json data
     *
     * @param $json_data
     *
     * @return Campsite[]
     */
    private function getCampsitesFromJsonData($json_data): array
    {
        return array_map(function($campsite) {
            return new Campsite($campsite->id, $campsite->name);
        }, $json_data->campsites);
    }

    /**
     * Create Reservation array for given Campsite
     *
     * @param Campsite $campsite
     * @param $json_data
     *
     * @return Reservation[]
     *
     * @throws \Exception
     */
    private function getReservationsForCampsiteFromJsonData(Campsite $campsite, $json_data): array
    {
        $campsite_id = $campsite->getId();

        $reservations_for_campsite = array_filter(
            $json_data->reservations,
            function($reservation) use ($campsite_id) {
                return $reservation->campsiteId === $campsite_id;
            }
        );

        return array_map(function($reservation) {
            $date_range = new DateRange(new \DateTime($reservation->startDate), new \DateTime($reservation->endDate));
            return new Reservation($reservation->campsiteId, $date_range);
        }, $reservations_for_campsite);
    }

    /**
     * @return SchedulingRule[]
     */
    private function getSchedulingRules(): array
    {
        return [
            new AlreadyReservedSchedulingRule(),
            new OneNightGapSchedulingRule()
        ];
    }
}