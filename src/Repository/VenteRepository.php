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

    public function salesOfUser(int $clientId): float
    {
        return $this->createQueryBuilder('v')
            ->select('COALESCE(SUM(v.montantTotal), 0)')
            ->where('v.client = :clientId')
            ->setParameter('clientId', $clientId)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function numberOfSalesPerUser(int $clientId): int
    {
        return $this->createQueryBuilder('v')
            ->select('COUNT(v.client)')
            ->where('v.client = :clientId')
            ->setParameter('clientId', $clientId)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function lastSaleDate(int $clientId)
    {
        return $this->createQueryBuilder('v')
            ->select('v.date')
            ->where('v.client = :clientId')
            ->setParameter('clientId', $clientId)
            ->orderBy('v.date', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function lastSaleAmount(int $clientId): float
    {
        return $this->createQueryBuilder('v')
            ->select('v.montantTotal')
            ->where('v.client = :clientId')
            ->setParameter('clientId', $clientId)
            ->orderBy('v.date', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findByClient(int$clientId)
    {
        return $this->createQueryBuilder('v')
            ->where('v.client = :clientId')
            ->setParameter('clientId', $clientId)
            ->getQuery()
            ->getResult();
    }
}
