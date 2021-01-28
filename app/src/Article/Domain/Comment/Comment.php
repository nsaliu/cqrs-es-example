<?php

declare(strict_types=1);

namespace App\Article\Domain\Comment;

use App\Article\Domain\ArticleUuid;
use App\Article\Domain\AuthorUuid;
use App\Article\Domain\CommentUuid;
use DateTimeImmutable;

final class Comment
{
    private CommentUuid $commentUuid;

    private ArticleUuid $articleUuid;

    private AuthorUuid $authorUuid;

    private string $text;

    private DateTimeImmutable $createdAt;

    public function __construct(
        CommentUuid $commentUuid,
        ArticleUuid $articleUuid,
        AuthorUuid $authorUuid,
        string $text,
        DateTimeImmutable $createdAt
    ) {
        $this->commentUuid = $commentUuid;
        $this->articleUuid = $articleUuid;
        $this->authorUuid = $authorUuid;
        $this->text = $text;
        $this->createdAt = $createdAt;
    }

    public function getCommentUuid(): CommentUuid
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

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
