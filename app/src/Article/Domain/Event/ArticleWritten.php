<?php

declare(strict_types=1);

namespace App\Article\Domain\Event;

use App\Article\Domain\ArticleUuid;
use App\Article\Domain\AuthorUuid;
use DateTimeImmutable;
use DateTimeInterface;
use EventSauce\EventSourcing\Serialization\SerializablePayload;
use InvalidArgumentException;

final class ArticleWritten implements SerializablePayload
{
    private ArticleUuid $articleUuid;

    private AuthorUuid $authorUuid;

    private string $title;

    private string $text;

    private DateTimeInterface $occurredAt;

    public function __construct(
        ArticleUuid $articleUuid,
        AuthorUuid $authorUuid,
        string $title,
        string $text,
        DateTimeImmutable $occurredAt
    ) {
        $this->articleUuid = $articleUuid;
        $this->authorUuid = $authorUuid;
        $this->title = $title;
        $this->text = $text;
        $this->occurredAt = $occurredAt;
    }

    public function getArticleUuid(): ArticleUuid
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

    public function getOccurredAt(): DateTimeInterface
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
            'author_uuid' => $this->authorUuid->toString(),
            'title' => $this->title,
            'text' => $this->text,
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

        return new ArticleWritten(
            ArticleUuid::fromString($payload['article_uuid']),
            AuthorUuid::fromString($payload['author_uuid']),
            (string) $payload['title'],
            (string) $payload['text'],
            $occurredAt
        );
    }
}
