<?php

declare(strict_types=1);

namespace App\Article\Application\Command;

use App\Article\Domain\Repository\ArticleRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

final class DeleteCommentCommandHandler implements MessageSubscriberInterface
{
    private ArticleRepositoryInterface $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function __invoke(DeleteCommentCommand $command): void
    {
        $article = $this->articleRepository->get($command->getAggregateUuid());

        $article->deleteComment(
            $command->getAggregateUuid(),
            $command->getCommentUuid(),
            $command->getAuthorUuid()
        );

        $this->articleRepository->save($article);
    }

    /**
     * @return iterable<string>
     */
    public static function getHandledMessages(): iterable
    {
        yield DeleteCommentCommand::class;
    }
}
