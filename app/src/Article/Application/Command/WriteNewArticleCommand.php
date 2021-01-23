<?php

declare(strict_types=1);

namespace App\Article\Application\Command;

use App\Article\Domain\ArticleUuid;
use App\Article\Domain\AuthorUuid;

final class WriteNewArticleCommand implements CommandInterface
{
    private ArticleUuid $articleUuid;

    private AuthorUuid $authorUuid;

    private string $title;

    private string $text;

    public function __construct(
        ArticleUuid $articleUuid,
        AuthorUuid $authorUuid,
        string $title,
        string $text
    ) {
        $this->articleUuid = $articleUuid;
        $this->authorUuid = $authorUuid;
        $this->title = $title;
        $this->text = $text;
    }

    public function getAggregateUuid(): ArticleUuid
    {
        return $this->articleUuid;
    }

    public function getAuthorUuid(): AuthorUuid
    {
        return $this->authorUuid;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
