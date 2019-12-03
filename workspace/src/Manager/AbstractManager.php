<?php

namespace App\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Class AbstractManager.
 */
abstract class AbstractManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var EntityRepository
     */
    protected $repository;

    /**
     * @return object|null
     */
    public function findById(int $id)
    {
        return $this->repository->find($id);
    }
}
