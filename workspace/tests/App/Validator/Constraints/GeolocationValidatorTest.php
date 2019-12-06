<?php

namespace Tests\App\Validator\Constraints;

use App\Validator\Constraints\Geolocation;
use App\Validator\Constraints\GeolocationValidator;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class DatalayerValueValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator(): GeolocationValidator
    {
        return new GeolocationValidator();
    }

    /**
     * @dataProvider getGeolocationsWithValidValues
     */
    public function test validator valid values($condition)
    {
        $constraint = new Geolocation();
        $this->validator->validate($condition, $constraint);
        $this->assertNoViolation();
    }

    /**
     * @dataProvider getGeolocationsWithInvalidValues
     */
    public function test validator invalid values($condition)
    {
        $constraint = new Geolocation();
        $this->validator->validate($condition, $constraint);
        $this->buildViolation($constraint->message)
            ->assertRaised();
    }

    public function getGeolocationsWithValidValues(): array
    {
        return [
            ['+90.0,-127.554334'],
            ['45,180'],
            ['-90,-180'],
            ['-90.000,-180.0000'],
            ['+90,+180'],
            ['47.1231231,179.99999999'],
            ['0,0']
        ];
    }

    public function getGeolocationsWithInvalidValues(): array
    {
        return [
            ['-90.,-180.'],
            ['+90.1,-100.111'],
            ['-91,123.456'],
            ['045,180'],
        ];
    }
}
