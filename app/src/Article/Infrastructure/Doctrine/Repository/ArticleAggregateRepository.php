<?php

declare(strict_types=1);

namespace App\Article\Infrastructure\Doctrine\Repository;

use App\Article\Domain\Article;
use App\Article\Domain\ArticleUuid;
use App\Article\Domain\Repository\ArticleRepositoryInterface;
use EventSauce\EventSourcing\AggregateRootRepository;

final class ArticleAggregateRepository implements ArticleRepositoryInterface
{
    private AggregateRootRepository $aggregateRootRepository;

    public function __construct(
        AggregateRootRepository $aggregateRootRepository
    ) {
        $this->aggregateRootRepository = $aggregateRootRepository;
    }

    public function save(Article $article): void
    {
        $this->aggregateRootRepository->persist($article);
    }

    public function get(ArticleUuid $userUuidUuid): Article
    {
        /** @var Article $article */
        $article = $this->aggregateRootRepository->retrieve($userUuidUuid);

        return $article;
    }
}
