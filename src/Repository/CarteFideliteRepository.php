<?php

namespace App\Repository;

use App\Entity\CarteFidelite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CarteFidelite>
 */
class CarteFideliteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarteFidelite::class);
    }

    public function loyaltyPoints(): int
    {
        return $this->createQueryBuilder('cf')
            ->select('SUM(cf.soldePoints)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
