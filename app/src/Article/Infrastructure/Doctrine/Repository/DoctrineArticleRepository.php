<?php

declare(strict_types=1);

namespace App\Article\Infrastructure\Doctrine\Repository;

use App\Article\Domain\ArticleUuid;
use App\Article\Infrastructure\Doctrine\Entity\DoctrineArticle;
use App\Article\Infrastructure\Doctrine\Exception\ArticleNotFoundByUuidException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class DoctrineArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoctrineArticle::class);
    }

    public function findByUuid(ArticleUuid $articleUuid): DoctrineArticle
    {
        /** @var DoctrineArticle|null $article */
        $article = $this->findOneBy([
            'articleUuid' => $articleUuid,
        ]);

        if ($article === null) {
            throw new ArticleNotFoundByUuidException($articleUuid);
        }

        return $article;
    }

    public function persist(DoctrineArticle $article): void
    {
        $this->getEntityManager()->persist($article);
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }
}
