<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Validator\Constraints as AppAssert;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Order.
 *
 * @ORM\Table(name="`order`")
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 *
 * @JMS\AccessorOrder("custom", custom = {"id", "distance", "status"})
 */
class Order implements OrderInterface
{
    use Timestampable;

    const STATUS_UNASSIGNED = 1;
    const STATUS_TAKEN = 2;

    const STATUS_UNASSIGNED_LABEL = 'UNASSIGNED';
    const STATUS_TAKEN_LABEL = 'TAKEN';

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @JMS\Groups({"list", "post"})
     */
    protected $id;

    /**
     * @var string
     *
     * @AppAssert\Geolocation()
     * @Assert\NotNull()
     * @ORM\Column(type="string", length=25)
     */
    protected $originGeolocation;

    /**
     * @var string
     *
     * @AppAssert\Geolocation()
     * @Assert\NotNull()
     * @ORM\Column(type="string", length=25)
     */
    protected $destinationGeolocation;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     *
     * @JMS\Groups({"list", "post"})
     */
    protected $distance;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    protected $status;

    public function __construct()
    {
        $this->status = self::STATUS_UNASSIGNED;
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getOriginGeolocation(): ?string
    {
        return $this->originGeolocation;
    }

    /**
     * {@inheritdoc}
     */
    public function setOriginGeolocation(string $originGeolocation): self
    {
        $this->originGeolocation = $originGeolocation;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDestinationGeolocation(): ?string
    {
        return $this->destinationGeolocation;
    }

    /**
     * {@inheritdoc}
     */
    public function setDestinationGeolocation(string $destinationGeolocation): self
    {
        $this->destinationGeolocation = $destinationGeolocation;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDistance(): ?int
    {
        return $this->distance;
    }

    /**
     * {@inheritdoc}
     */
    public function setDistance(int $distance): self
    {
        $this->distance = $distance;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * {@inheritdoc}
     */
    public function setStatus(?int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public static function getStatuses(): array
    {
        return [
            self::STATUS_UNASSIGNED => self::STATUS_UNASSIGNED_LABEL,
            self::STATUS_TAKEN => self::STATUS_TAKEN_LABEL,
        ];
    }

    /**
     * @JMS\Groups({"list", "post", "patch"})
     * @JMS\VirtualProperty
     * @JMS\SerializedName("status")
     */
    public function getStatusLabel(): string
    {
        return self::getStatuses()[$this->getStatus()] ?? self::STATUS_UNASSIGNED_LABEL;
    }
}
