<?php

declare(strict_types=1);

namespace App\Article\Application\Command;

use App\Article\Domain\Repository\ArticleRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

final class AddCommentCommandHandler implements MessageSubscriberInterface
{
    private ArticleRepositoryInterface $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function __invoke(AddCommentCommand $command): void
    {
        $article = $this->articleRepository->get($command->getArticleUuid());

        $article->addComment(
            $command->getAggregateUuid(),
            $command->getArticleUuid(),
            $command->getAuthorUuid(),
            $command->getText()
        );

        $this->articleRepository->save($article);
    }

    /**
     * @return iterable<string>
     */
    public static function getHandledMessages(): iterable
    {
        yield AddCommentCommand::class;
    }
}
