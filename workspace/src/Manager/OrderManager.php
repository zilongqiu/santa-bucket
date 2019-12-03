<?php

namespace App\Manager;

use App\Client\GoogleClient;
use App\Entity\Order;
use App\Entity\OrderInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class OrderManager.
 */
class OrderManager extends AbstractManager
{
    /**
     * @var GoogleClient
     */
    private $googleClient;

    /**
     * OrderManager constructor.
     */
    public function __construct(EntityManagerInterface $entityManager, GoogleClient $googleClient)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Order::class);
        $this->googleClient = $googleClient;
    }

    /**
     * Create an order.
     */
    public function create(OrderInterface $order): void
    {
        $order->setDistance($this->googleClient->getDistanceInMeters($order->getOriginGeolocation(), $order->getDestinationGeolocation()));
        $this->save($order);
    }

    /**
     * Take an order.
     *
     * @throws \Exception
     */
    public function take(OrderInterface $order): void
    {
        $this->entityManager->beginTransaction();
        try {
            $this->save($order);
            $this->entityManager->commit();
        } catch (\Exception $e) {
            $this->entityManager->rollBack();
            throw $e;
        }
    }

    /**
     * Save a order.
     */
    public function save(OrderInterface $order): void
    {
        $this->repository->save($order);
    }
}
