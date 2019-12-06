<?php

namespace Tests\App\Manager;

use App\Entity\Order;
use App\Form\OrderType;
use Tests\App\Form\AbstractFormTypeTest;

class OrderTypeTest extends AbstractFormTypeTest
{
    /**
     * @dataProvider getValidValues
     */
    public function test submit valid parameters($origin, $destination)
    {
        $order = new Order();
        $order->setOriginGeolocation(implode(',', $origin))
            ->setDestinationGeolocation(implode(',', $destination));

        $this->formTestData(OrderType::class, [
            'origin' => $origin,
            'destination' => $destination,
        ], $order);
    }

    /**
     * @dataProvider getInvalidValues
     */
    public function test submit invalid parameters($origin, $destination)
    {
        $this->formTestData(OrderType::class, [
            'origin' => $origin,
            'destination' => $destination,
        ], new Order());
    }

    /**
     * @dataProvider getValidStatuses
     */
    public function test submit valid status($statusLabel, $statusCode)
    {
        $order = new Order();
        $order->setOriginGeolocation('0,0')
            ->setDestinationGeolocation('0,0')
            ->setStatus($statusCode);

        $this->formTestData(OrderType::class, [
            'origin' => ['0','0'],
            'destination' => ['0','0'],
            'status' => $statusLabel
        ], $order);
    }


    public function test submit invalid status()
    {
        $order = new Order();
        $order->setStatus(Order::STATUS_UNASSIGNED);

        $this->formTestData(OrderType::class, [
            'status' => 'toto'
        ], $order);
    }

    public function getValidValues(): array
    {
        return [
            [['+90.0', '-127.554334'], ['45', '180']],
            [['-90', '-180'], ['-90.000', '-180.0000']],
            [['+90', '+180'], ['47.1231231', '179.99999999']],
            [['0', '0'], ['0', '0']],
        ];
    }

    public function getInvalidValues(): array
    {
        return [
            [[], []],
            ['', 1],
            [[90.0, -127.554334], [45, 180]],
            [[1, '-127.554334'], ['-90.000', -180.0000]],
            [['', 181], ['-1', -180.0000]],
            [['1', '2', '3'], ['1', '2', '3', '4']],
        ];
    }

    public function getValidStatuses(): array
    {
        return [
            [Order::STATUS_UNASSIGNED_LABEL, Order::STATUS_UNASSIGNED],
            [Order::STATUS_TAKEN_LABEL, Order::STATUS_TAKEN],
        ];
    }
}
