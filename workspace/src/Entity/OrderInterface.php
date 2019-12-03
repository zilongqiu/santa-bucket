<?php

namespace App\Entity;

/**
 * Interface OrderInterface.
 */
interface OrderInterface
{
    /**
     * Return the order's id.
     */
    public function getId(): int;

    public function getOriginGeolocation(): ?string;

    public function setOriginGeolocation(string $originGeolocation);

    public function getDestinationGeolocation(): ?string;

    public function setDestinationGeolocation(string $destinationGeolocation);

    public function getDistance(): ?int;

    /**
     * Distance between original and destination location in meters (by car).
     */
    public function setDistance(int $distance);

    public function getStatus(): ?int;

    public function setStatus(?int $status);
}
