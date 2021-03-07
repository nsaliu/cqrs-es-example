<?php

declare(strict_types=1);

namespace App\Article\Domain\Event;

use App\Article\Domain\ArticleUuid;
use App\Article\Domain\AuthorUuid;
use App\Article\Domain\CommentUuid;
use EventSauce\EventSourcing\Serialization\SerializablePayload;

final class CommentDeleted implements SerializablePayload
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

    /**
     * @return array<string, mixed>
     */
    public function toPayload(): array
    {
        return [
            'article_uuid' => $this->articleUuid->toString(),
            'comment_uuid' => $this->commentUuid->toString(),
            'author_uuid' => $this->authorUuid->toString(),
        ];
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromPayload(array $payload): SerializablePayload
    {
        return new CommentDeleted(
            ArticleUuid::fromString((string) $payload['article_uuid']),
            CommentUuid::fromString((string) $payload['comment_uuid']),
            AuthorUuid::fromString((string) $payload['author_uuid']),
        );
    }
}
