<?php

declare(strict_types=1);

namespace App\Article\Application\Command;

use App\Article\Domain\ArticleUuid;
use App\Article\Domain\AuthorUuid;
use App\Article\Domain\CommentUuid;

final class DeleteCommentCommand implements CommandInterface
{
    private ArticleUuid $articleUuid;

    private CommentUuid $commentUuid;

    private AuthorUuid $authorUuid;

    public function __construct(
        ArticleUuid $articleUuid,
        CommentUuid $commentUuid,
        AuthorUuid $authorUuid
    ) {
        $this->articleUuid = $articleUuid;
        $this->commentUuid = $commentUuid;
        $this->authorUuid = $authorUuid;
    }

    public function getAggregateUuid(): ArticleUuid
    {
        return $this->articleUuid;
    }

    public function getCommentUuid(): CommentUuid
    {
        return $this->commentUuid;
    }

    public function getAuthorUuid(): AuthorUuid
    {
        return $this->authorUuid;
    }
}
