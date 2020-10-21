<?php
namespace App\Domain;

class Reservation
{
    /*
     * @var int Campsite ID
     */
    protected $campsite_id;

    /*
     * @var DateRange Dates of reservation
     */
    protected $date_range;

    public function __construct(int $campsite_id, DateRange $date_range)
    {
        $this->campsite_id = $campsite_id;
        $this->date_range= $date_range;
    }

    /**
     * Get Campsite ID
     *
     * @return int
     */
    public function getCampsiteId(): int
    {
        return $this->campsite_id;
    }

    /**
     * Set Campsite ID
     *
     * @param int $campsite_id
     */
    public function setCampsiteId(int $campsite_id): void
    {
        $this->campsite_id = $campsite_id;
    }

    /**
     * Get Date Range
     *
     * @return DateRange
     */
    public function getDateRange(): DateRange
    {
        return $this->date_range;
    }

    /**
     * Set Date Range
     *
     * @param DateRange $dateRange
     */
    public function setDateRange(DateRange $dateRange): void
    {
        $this->date_range = $dateRange;
    }
}