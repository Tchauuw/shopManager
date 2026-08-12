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

    // Filter
    public function findByFilters(?string $search = null): array
    {
        $qb = $this->createQueryBuilder('c')
            ->orderBy('c.id', 'DESC');

        if($search) {
            $qb
                ->andWhere('c.nom LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }

        return $qb->getQuery()->getResult();
    }


    // Access datas 
    public function findAllOrderedById()
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.id', 'DESC')
            ->getQuery();
    }

    public function findLoyalClients(): array
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
            ->groupBy('c.id')
            ->having('COUNT(v.id) > 0')
            ->getQuery()
            ->getResult();
    }

    public function clientsCount(): int
    {
        return $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function newClients(): int
    {
        $date = new \DateTimeImmutable('-30 days');
        return (int) $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->where('c.dateCreation >= :date')
            ->setParameter('date', $date)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
