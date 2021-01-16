<?php

declare(strict_types=1);

namespace App\Article\Application\Command;

use App\Article\Domain\Article;
use App\Article\Domain\Repository\ArticleRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

final class WriteNewArticleCommandHandler implements MessageSubscriberInterface
{
    private ArticleRepositoryInterface $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function __invoke(WriteNewArticleCommand $command): void
    {
        $article = Article::create($command->getAggregateUuid());

        $article->writeNew(
            $command->getAuthorUuid(),
            $command->getTitle(),
            $command->getText()
        );

        $this->articleRepository->save($article);
    }

    /**
     * @return iterable<string>
     */
    public static function getHandledMessages(): iterable
    {
        yield WriteNewArticleCommand::class;
    }
}
