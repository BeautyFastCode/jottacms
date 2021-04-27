<?php declare(strict_types=1);


namespace App\Repository;


use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

abstract class BaseEntityRepository extends ServiceEntityRepository implements EntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, $this->getSupportsEntityName());
    }

    abstract protected function getSupportsEntityName(): string;
}
