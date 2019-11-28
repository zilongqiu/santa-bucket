<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use Doctrine\ORM\Mapping as ORM;

class Order implements OrderInterface
{
    use Timestampable;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", precision=10, scale=8)
     */
    protected $originLatitude;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", precision=11, scale=8)
     */
    protected $originLongitude;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", precision=10, scale=8)
     */
    protected $destinationLatitude;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", precision=11, scale=8)
     */
    protected $destinationLongitude;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    protected $distance;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint")
     */
    protected $status;

    /**
     * @inheritDoc
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getOriginLatitude(): float
    {
        return $this->originLatitude;
    }

    /**
     * @param float $originLatitude
     *
     * @return self
     */
    public function setOriginLatitude(float $originLatitude): self
    {
        $this->originLatitude = $originLatitude;

        return $this;
    }

    /**
     * @return float
     */
    public function getOriginLongitude(): float
    {
        return $this->originLongitude;
    }

    /**
     * @param float $originLongitude
     *
     * @return self
     */
    public function setOriginLongitude(float $originLongitude): self
    {
        $this->originLongitude = $originLongitude;

        return $this;
    }

    /**
     * @return float
     */
    public function getDestinationLatitude(): float
    {
        return $this->destinationLatitude;
    }

    /**
     * @param float $destinationLatitude
     *
     * @return self
     */
    public function setDestinationLatitude(float $destinationLatitude): self
    {
        $this->destinationLatitude = $destinationLatitude;

        return $this;
    }

    /**
     * @return float
     */
    public function getDestinationLongitude(): float
    {
        return $this->destinationLongitude;
    }

    /**
     * @param float $destinationLongitude
     *
     * @return self
     */
    public function setDestinationLongitude(float $destinationLongitude): self
    {
        $this->destinationLongitude = $destinationLongitude;

        return $this;
    }

    /**
     * @return int
     */
    public function getDistance(): int
    {
        return $this->distance;
    }

    /**
     * @param int $distance
     *
     * @return self
     */
    public function setDistance(int $distance): self
    {
        $this->distance = $distance;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     *
     * @return self
     */
    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }
}
