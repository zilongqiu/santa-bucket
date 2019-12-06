<?php

namespace Tests\App\Manager;

use App\Client\GoogleClient;
use App\Entity\Order;
use App\Entity\OrderInterface;
use App\Manager\OrderManager;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;

class OrderManagerTest extends TestCase
{
    /**
     * @var ObjectProphecy
     */
    private $entityManagerMock;

    /**
     * @var ObjectProphecy
     */
    private $orderRepositoryMock;

    /**
     * @var ObjectProphecy
     */
    private $googleClientMock;

    /**
     * @var OrderManager
     */
    private $orderManager;

    public function setUp(): void
    {
        $this->entityManagerMock = $this->prophesize(EntityManager::class);
        $this->orderRepositoryMock = $this->prophesize(OrderRepository::class);
        $this->entityManagerMock
            ->getRepository(Argument::exact(Order::class))
            ->willReturn($this->orderRepositoryMock->reveal())
            ->shouldBeCalledOnce();

        $this->googleClientMock = $this->prophesize(GoogleClient::class);

        $this->orderManager = new OrderManager($this->entityManagerMock->reveal(), $this->googleClientMock->reveal());
    }

    public function test create success()
    {
        $order = new Order();
        $order->setOriginGeolocation('48.9268741,2.3785176');
        $order->setDestinationGeolocation('48.8566969,2.3514616');

        $this->orderRepositoryMock
            ->save(Argument::type(OrderInterface::class))
            ->shouldBeCalledOnce();

        $expectedDistance = 21538;
        $this->googleClientMock
            ->getDistanceInMeters($order->getOriginGeolocation(), $order->getDestinationGeolocation())
            ->willReturn($expectedDistance)
            ->shouldBeCalledOnce();

        $this->orderManager->create($order);
        $this->assertEquals($expectedDistance, $order->getDistance());
    }

    public function test take success()
    {
        $order = new Order();

        $this->entityManagerMock
            ->beginTransaction()
            ->shouldBeCalledOnce();

        $this->entityManagerMock
            ->commit()
            ->shouldBeCalledOnce();

        $this->orderRepositoryMock
            ->save(Argument::type(OrderInterface::class))
            ->shouldBeCalledOnce();

        $this->orderManager->take($order);
    }

    public function test take failure()
    {
        $order = new Order();

        $this->entityManagerMock
            ->beginTransaction()
            ->shouldBeCalledOnce();

        $this->entityManagerMock
            ->rollback()
            ->shouldBeCalledOnce();

        $this->entityManagerMock
            ->commit()
            ->shouldNotBeCalled();

        $this->orderRepositoryMock
            ->save(Argument::type(OrderInterface::class))
            ->willThrow(new \Exception())
            ->shouldBeCalledOnce();

        $this->expectException(\Exception::class);
        $this->orderManager->take($order);
    }

    public function test findby()
    {
        $this->orderRepositoryMock
            ->find(Argument::type('integer'))
            ->shouldBeCalledOnce();

        $this->orderManager->findById(1);
    }

    public function test save success()
    {
        $this->orderRepositoryMock
            ->save(Argument::type(OrderInterface::class))
            ->shouldBeCalledOnce();

        $this->orderManager->save(new Order());
    }
}
