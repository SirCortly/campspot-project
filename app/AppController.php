<?php
namespace App;

use App\Domain\Campsite;
use App\Domain\DateRange;
use App\Domain\Reservation;
use App\SchedulingRules\OneNightGapSchedulingRule;
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
     * @param $json_data
     */
    public function handle($json_data): void
    {
        $date_range = $this->getDateRangeFromJsonData($json_data);
        $campsites = $this->getCampsitesFromJsonData($json_data);

        $availableCampsites = [];
        foreach ($campsites as $campsite) {
            $reservations = $this->getReservationsForCampsiteFromJsonData($campsite, $json_data);
            if ($this->scheduling_service->isCampsiteAvailable($date_range, $campsite, $reservations, [new OneNightGapSchedulingRule()])) {
                $availableCampsites[] = $campsite;
            }
        }
    }

    /**
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
}