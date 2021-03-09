<?php

declare(strict_types=1);

namespace App\Article\Domain\Event;

use App\Article\Domain\ArticleUuid;
use App\Article\Domain\AuthorUuid;
use App\Article\Domain\CommentUuid;
use DateTimeImmutable;
use EventSauce\EventSourcing\Serialization\SerializablePayload;
use InvalidArgumentException;

final class CommentDeleted implements SerializablePayload
{
    private ArticleUuid $articleUuid;

    private CommentUuid $commentUuid;

    private AuthorUuid $authorUuid;

    private DateTimeImmutable $occurredAt;

    public function __construct(
        ArticleUuid $articleUuid,
        CommentUuid $commentUuid,
        AuthorUuid $authorUuid,
        DateTimeImmutable $occurredAt
    ) {
        $this->articleUuid = $articleUuid;
        $this->commentUuid = $commentUuid;
        $this->authorUuid = $authorUuid;
        $this->occurredAt = $occurredAt;
    }

    public function getArticleUuid(): ArticleUuid
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

    public function getOccurredAt(): DateTimeImmutable
    {
        return $this->occurredAt;
    }

    /**
     * @return array<string, mixed>
     */
    public function toPayload(): array
    {
        return [
            'article_uuid' => $this->articleUuid->toString(),
            'comment_uuid' => $this->commentUuid->toString(),
            'author_uuid' => $this->authorUuid->toString(),
            'occurred_at' => $this->occurredAt->format(DATE_ATOM),
        ];
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromPayload(array $payload): SerializablePayload
    {
        $occurredAt = DateTimeImmutable::createFromFormat(
            DATE_ATOM,
            $payload['occurred_at']
        );

        if ($occurredAt === false) {
            throw new InvalidArgumentException(sprintf('OccurredAt must be a valid date, %s given.', $payload['occurred_at']));
        }

        return new CommentDeleted(
            ArticleUuid::fromString((string) $payload['article_uuid']),
            CommentUuid::fromString((string) $payload['comment_uuid']),
            AuthorUuid::fromString((string) $payload['author_uuid']),
            $occurredAt
        );
    }
}
