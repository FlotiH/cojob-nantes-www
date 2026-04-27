<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Promo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PromoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Promo::class);
    }

    /**
     * @return Promo[] Returns an array of open Promo
     */
    public function findOpenPromos(): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.registeringStart <= :date')
            ->andWhere('p.registeringEnd >= :date')
            ->andWhere('p.helloAssoFormLink IS NOT NULL')
            ->setParameter('date', new \DateTime())
            ->orderBy('p.start', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Promo[] Returns an array of available Promo
     */
    public function findAvailablePromos(): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.helloAssoFormLink IS NOT NULL')
            ->andWhere('p.registeringStart <= :date')
            ->andWhere('p.registeringEnd >= :date')
            ->setParameter('date', new \DateTime())
            ->orderBy('p.start', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Promo[] Returns an array of not yet available Promo
     */
    public function findNotAvailablePromos(): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.start >= :date')
            ->andWhere('p.registeringStart >= :date')
            ->setParameter('date', new \DateTime())
            ->orderBy('p.start', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
