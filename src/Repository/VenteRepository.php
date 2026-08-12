<?php

namespace App\Repository;

use App\Entity\Vente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vente>
 */
class VenteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vente::class);
    }

    public function totalSales(): float
    {
        return $this->createQueryBuilder('v')
            ->select('SUM(v.montantTotal)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function salesThisMonth(): float
    {
        $date = new \DateTimeImmutable('-30 days');

        return $this->createQueryBuilder('v')
            ->setParameter('date', $date)
            ->select('SUM(v.montantTotal)')
            ->where('v.date > :date')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
