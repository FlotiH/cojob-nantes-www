<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Testimony;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Testimony>
 */
class TestimonyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Testimony::class);
    }

    /**
     * @return Testimony[] Returns an array of max 6 required Testimony on Promo
     */
    public function findRequiredPromoTestimonies(): array
    {
        return $this->createQueryBuilder('t')
            ->where('t.promo = 1')
            ->andWhere('t.requiredDisplaying = 1')
            ->orderBy('RAND()')
            ->setMaxResults(6)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Testimony[] Returns an array of not required Testimony on Promo
     */
    public function findNotRequiredPromoTestimonies(int $nbRequiredTestmonies = 0): array
    {
        return $this->createQueryBuilder('t')
            ->where('t.promo = 1')
            ->andWhere('t.requiredDisplaying = 0')
            ->orderBy('RAND()')
            ->setMaxResults(6 - $nbRequiredTestmonies)
            ->getQuery()
            ->getResult();
    }
}
