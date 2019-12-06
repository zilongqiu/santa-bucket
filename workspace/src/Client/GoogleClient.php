<?php

namespace App\Client;

/**
 * Class GoogleClient.
 */
class GoogleClient
{
    /**
     * @var string
     */
    const BASE_CLIENT_URL = 'https://maps.googleapis.com/maps/api/';

    /**
     * @var string
     */
    const CLIENT_STATUS_SUCCESS = 'OK';

    /**
     * @var string|null
     */
    private $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Get driving distance between two geolocation (in meters)
     */
    public function getDistanceInMeters(string $originGeolocation, string $destinationGeolocation): int
    {
        $details = self::BASE_CLIENT_URL."distancematrix/json?origins=$originGeolocation&destinations=$destinationGeolocation&mode=driving&sensor=false&units=metric&key={$this->apiKey}";

        $response = json_decode(file_get_contents($details), true);
        if ($response && self::CLIENT_STATUS_SUCCESS === $response['status']) {
            return ($response['rows'][0]['elements'][0]['distance']['value']) ?? 0;
        }

        return 0;
    }
}
