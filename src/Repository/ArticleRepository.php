<?php

declare(strict_types=1);

namespace App\Repository;

use App\Config\ArticleTag;
use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * @return Article[] Returns an array of published Article
     */
    public function findPublishedArticles(): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.publishedAt IS NOT NULL AND a.publishedAt <= :date')
            ->andWhere('a.expiresAt IS NULL OR a.expiresAt > :date')
            ->setParameter('date', new \DateTime())
            ->orderBy('a.publishedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findNextAperotaf(): ?Article
    {
        return $this->createQueryBuilder('a')
            ->where('a.publishedAt IS NOT NULL AND a.publishedAt <= :date')
            ->andWhere('a.expiresAt IS NULL OR a.expiresAt > :date')
            ->andWhere('a.tag = :aperotaf')
            ->setParameter('aperotaf', ArticleTag::Aperotaf)
            ->setParameter('date', new \DateTime())
            ->orderBy('a.start', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult(Query::HYDRATE_OBJECT)
        ;
    }
}
