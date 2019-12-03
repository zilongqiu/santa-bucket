<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class Geolocation.
 *
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
class Geolocation extends Constraint
{
    /**
     * @var string
     */
    public $message = "You've entered an invalid latitude/longitude format. Expected exemple: ['48.9268741', '2.3785176']";

    /**
     * @var string
     */
    public $validationRegex = '#^[-+]?([1-8]?\d(\.\d+)?|90(\.0+)?),\s*[-+]?(180(\.0+)?|((1[0-7]\d)|([1-9]?\d))(\.\d+)?)$#';
}
