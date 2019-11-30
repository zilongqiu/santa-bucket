<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Order.
 *
 * @ORM\Table(name="order")
 * @ORM\Entity()
 */
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
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $distance;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    protected $status;

    /**
     * {@inheritdoc}
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function getOriginLatitude(): float
    {
        return $this->originLatitude;
    }

    public function setOriginLatitude(float $originLatitude): self
    {
        $this->originLatitude = $originLatitude;

        return $this;
    }

    public function getOriginLongitude(): float
    {
        return $this->originLongitude;
    }

    public function setOriginLongitude(float $originLongitude): self
    {
        $this->originLongitude = $originLongitude;

        return $this;
    }

    public function getDestinationLatitude(): float
    {
        return $this->destinationLatitude;
    }

    public function setDestinationLatitude(float $destinationLatitude): self
    {
        $this->destinationLatitude = $destinationLatitude;

        return $this;
    }

    public function getDestinationLongitude(): float
    {
        return $this->destinationLongitude;
    }

    public function setDestinationLongitude(float $destinationLongitude): self
    {
        $this->destinationLongitude = $destinationLongitude;

        return $this;
    }

    public function getDistance(): int
    {
        return $this->distance;
    }

    public function setDistance(int $distance): self
    {
        $this->distance = $distance;

        return $this;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }
}
