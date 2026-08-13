<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
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
    public function findByFilters(
        ?string $searchFilter = null,
        ?string $newsletterFilter = null,
        ?string $cityFilter = null
        ): Query
    {
        $qb = $this->createQueryBuilder('c')
            ->orderBy('c.id', 'DESC');

        if($searchFilter) {
            $qb
                ->andWhere(
                    $qb->expr()->orX(
                        'c.nom LIKE :search',
                        'c.prenom LIKE :search',
                        'c.email LIKE :search',
                    )
                )
                ->setParameter('search', '%' . $searchFilter . '%');
        }

        if($newsletterFilter === 'oui') {
            $qb->andWhere('c.newsletter = 1');
        }

        if($newsletterFilter === 'non') {
            $qb->andWhere('c.newsletter = 0');
        }

        if ($cityFilter) {
            $qb
                ->andWhere('c.ville = :city')
                ->setParameter('city', $cityFilter);
        }

        return $qb->getQuery();
    }


    // Access datas 
    public function findAllOrderedById()
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.id', 'DESC')
            ->getQuery();
    }

    public function findAllCities(): array
    {
        return $this->createQueryBuilder('c')
            ->select('DISTINCT c.ville')
            ->groupBy('c.ville')
            ->getQuery()
            ->getResult();
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
