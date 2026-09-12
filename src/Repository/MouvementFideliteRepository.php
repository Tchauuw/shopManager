<?php

namespace App\Repository;

use App\Entity\MouvementFidelite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MouvementFidelite>
 */
class MouvementFideliteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MouvementFidelite::class);
    }

    public function moveThisMonth(): int
    {
        $date = new \DateTimeImmutable('-30 days');
        return $this->createQueryBuilder('mf')
            ->select('COALESCE(SUM(mf.points), 0)')
            ->where('mf.date >= :date')
            ->setParameter('date', $date)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findLoyaltyMovesByClient(int $clientId)
    {
        return $this->createQueryBuilder('mf')
            ->where('mf.id = :clientId')
            ->setParameter('clientId', $clientId)
            ->getQuery()
            ->getResult();
    }
}
