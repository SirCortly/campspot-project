<?php
namespace App\Domain;

class Campsite
{
    /*
     * @var int Campsite ID
     */
    protected $id;

    /*
     * @var string Campsite Name
     */
    protected $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * Get Campsite Id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set Campsite Id
     *
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Get Campsite Name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set Campsite Name
     *
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}