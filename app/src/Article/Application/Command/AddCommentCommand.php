<?php

declare(strict_types=1);

namespace App\Article\Application\Command;

use App\Article\Domain\ArticleUuid;
use App\Article\Domain\AuthorUuid;
use App\Article\Domain\CommentUuid;

final class AddCommentCommand implements CommandInterface
{
    private CommentUuid $commentUuid;

    private ArticleUuid $articleUuid;

    private AuthorUuid $authorUuid;

    private string $text;

    public function __construct(
        CommentUuid $commentUuid,
        ArticleUuid $articleUuid,
        AuthorUuid $authorUuid,
        string $text
    ) {
        $this->commentUuid = $commentUuid;
        $this->articleUuid = $articleUuid;
        $this->authorUuid = $authorUuid;
        $this->text = $text;
    }

    public function getAggregateUuid(): CommentUuid
    {
        return $this->commentUuid;
    }

    public function getArticleUuid(): ArticleUuid
    {
        return $this->articleUuid;
    }

    public function getAuthorUuid(): AuthorUuid
    {
        return $this->authorUuid;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
