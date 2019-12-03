<?php

namespace App\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class GeolocationArrayToStringTransformer.
 */
class GeolocationArrayToStringTransformer implements DataTransformerInterface
{
    const GEOLOCATION_PART_NUMBER = 2;

    /**
     * @param mixed $value
     *
     * @return string|null
     */
    public function transform($value)
    {
        if (null === $value) {
            return null;
        }

        return explode(',', $value);
    }

    /**
     * @param mixed $value
     *
     * @return string|null
     */
    public function reverseTransform($value)
    {
        if (null === $value
            || !\is_array($value)
            || self::GEOLOCATION_PART_NUMBER !== \count($value)
            || array_filter($value, function ($element) { return !\is_string($element); })
        ) {
            return null;
        }

        list($latitude, $longitude) = $value;

        return sprintf('%s,%s', $latitude, $longitude);
    }
}
