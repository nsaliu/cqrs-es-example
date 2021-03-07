<?php

declare(strict_types=1);

namespace App\Article\Domain;

use App\Article\Domain\Comment\Comment;
use App\Article\Domain\Event\ArticleWritten;
use App\Article\Domain\Event\CommentAdded;
use App\Article\Domain\Event\CommentDeleted;
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

    /**
     * @var Comment[]
     */
    private array $comments = [];

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

    public function addComment(
        CommentUuid $commentUuid,
        ArticleUuid $articleUuid,
        AuthorUuid $authorUuid,
        string $text
    ): void {
        $this->recordThat(
            new CommentAdded(
                $commentUuid,
                $articleUuid,
                $authorUuid,
                $text,
                new DateTimeImmutable()
            )
        );
    }

    public function deleteComment(
        ArticleUuid $articleUuid,
        CommentUuid $commentUuid,
        AuthorUuid $authorUuid
    ): void {
        $this->recordThat(
            new CommentDeleted(
                $articleUuid,
                $commentUuid,
                $authorUuid
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

    public function applyCommentAdded(CommentAdded $event): void
    {
        $this->comments[] = new Comment(
            $event->getCommentUuid(),
            $event->getArticleUuid(),
            $event->getAuthorUuid(),
            $event->getText(),
            $event->getCreatedAt()
        );
    }

    public function applyCommentDeleted(CommentDeleted $event): void
    {
        $comments = array_filter(
            $this->comments,
            function (Comment $comment) use ($event) {
                return $comment
                    ->getCommentUuid()
                    ->equalsTo(
                        $event->getCommentUuid()
                    );
            }
        );

        $this->comments = $comments;
    }
}
