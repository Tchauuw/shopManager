<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Client>
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    public function isLoyal(): array
    {
    $date = new \DateTimeImmutable('-30 days');
    return $this->createQueryBuilder('c')
        ->leftJoin(
            'c.ventes',
            'v',
            'WITH',
            'v.date >= :date'
        )
        ->setParameter('date', $date)
        ->addSelect('COUNT(v.id) AS nombreVentes')
        ->having('COUNT(v.id) >= 3')
        ->groupBy('c.id')
        ->getQuery()
        ->getResult();
    }
}
