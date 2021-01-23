<?php

declare(strict_types=1);

namespace App\Article\Domain;

use App\Article\Domain\Event\ArticleWritten;
use DateTimeImmutable;
use DateTimeInterface;
use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootBehaviour;

final class Article implements AggregateRoot
{
    use AggregateRootBehaviour;

    private AuthorUuid $authorUuid;

    private string $title;

    private string $text;

    private DateTimeInterface $createdAt;

    private DateTimeInterface $updatedAt;

    public static function create(ArticleUuid $articleUuid): self
    {
        return new static($articleUuid);
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

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function writeNew(
        AuthorUuid $authorUuid,
        string $title,
        string $text
    ): void {
        $this->recordThat(
            new ArticleWritten(
                ArticleUuid::fromString($this->aggregateRootId->toString()),
                $authorUuid,
                $title,
                $text,
                new DateTimeImmutable()
            )
        );
    }

    public function applyArticleWritten(ArticleWritten $event): void
    {
        $this->authorUuid = $event->getAuthorUuid();
        $this->title = $event->getTitle();
        $this->text = $event->getText();
        $this->createdAt = $event->getOccurredAt();
    }
}
