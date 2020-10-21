<?php
namespace App\Domain;

class DateRange
{
    public function __construct(\DateTime $start_date, \DateTime $end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    /*
     * @var DateTime Start Date
     */
    protected $start_date;

    /*
     * @var DateTime End Date
     */
    protected $end_date;

    /**
     * Get Start Date
     *
     * @return \DateTime
     */
    public function getStartDate(): \DateTime
    {
        return $this->start_date;
    }

    /**
     * Set Start Date
     *
     * @param \DateTime $start_date
     */
    public function setStartDate(\DateTime $start_date): void
    {
        $this->start_date = $start_date;
    }

    /**
     * Get End Date
     *
     * @return \DateTime
     */
    public function getEndDate(): \DateTime
    {
        return $this->end_date;
    }

    /**
     * Set End Date
     *
     * @param \DateTime $end_date
     */
    public function setEndDate(\DateTime $end_date): void
    {
        $this->end_date = $end_date;
    }
}