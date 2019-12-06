<?php

namespace Tests\App\DataTransformer;

use App\DataTransformer\GeolocationArrayToStringTransformer;
use PHPUnit\Framework\TestCase;

class GeolocationArrayToStringTransformerTest extends TestCase
{
    /**
     * @var GeolocationArrayToStringTransformer
     */
    private $dataTransformer;

    public function setUp()
    {
        $this->dataTransformer = new GeolocationArrayToStringTransformer();
    }

    /**
     * @dataProvider getTransformTests
     */
    public function test transform($value, $expectedResult)
    {
        $result = $this->dataTransformer->transform($value);
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @dataProvider getReverseTransformTests
     */
    public function test reverse transform($value, $expectedResult)
    {
        $result = $this->dataTransformer->reverseTransform($value);
        $this->assertEquals($expectedResult, $result);
    }

    public function getTransformTests(): array
    {
        return [
            [null, null],
            ['70,123', [70, 123]],
            ['0,0', [0, 0]],
            [',', ['', '']]
        ];
    }

    public function getReverseTransformTests(): array
    {
        return [
            [null, null],
            ['', null],
            [[], null],
            [[1], null],
            [[1, 2], null],
            [[1, 2 , 3], null],
            [[1, '+90'], null],
            [['1', '+90', '180'], null],
            [['0.00', '+90'], '0.00,+90'],
            [['-80', '180'], '-80,180'],
            [['', ''], ','],
        ];
    }
}
