<?php

declare(strict_types=1);

namespace App\Article\Application\Query;

use App\Article\Domain\Article;
use App\Article\Domain\Repository\ArticleRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

final class GetArticleByUuidQueryHandler implements MessageSubscriberInterface
{
    private ArticleRepositoryInterface $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function __invoke(GetArticleByUuidQuery $query): Article
    {
        return $this->articleRepository->get($query->getArticleUuid());
    }

    /**
     * @return iterable<string>
     */
    public static function getHandledMessages(): iterable
    {
        yield GetArticleByUuidQuery::class;
    }
}
