<?php

declare(strict_types=1);

namespace App\Article\Infrastructure\Doctrine\Entity;

use App\Article\Domain\ArticleUuid;
use App\Article\Domain\AuthorUuid;
use App\Article\Domain\CommentUuid;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="projection_comments",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(
 *             name="uuid_unq",
 *             columns={"uuid"}
 *         )
 *     }
 * )
 */
final class DoctrineComment
{
    /**
     * @ORM\Id()
     * @ORM\Column(
     *     name="uuid",
     *     type="comment_uuid",
     *     length=36
     * )
     */
    private CommentUuid $commentUuid;

    /**
     * @ORM\Id()
     * @ORM\Column(
     *     name="author_uuid",
     *     type="author_uuid",
     *     length=36
     * )
     */
    private AuthorUuid $authorUuid;

    /**
     * @ORM\Id()
     * @ORM\Column(
     *     name="article_uuid",
     *     type="article_uuid",
     *     length=36
     * )
     */
    private ArticleUuid $articleUuid;

    /**
     * @ORM\Column(
     *     name="body",
     *     type="text",
     *     nullable=false
     * )
     */
    private string $body;

    /**
     * @ORM\Column(
     *     name="created_at",
     *     type="date_immutable",
     *     nullable=false
     * )
     */
    private DateTimeImmutable $createdAt;

    public function __construct(
        CommentUuid $commentUuid,
        AuthorUuid $authorUuid,
        ArticleUuid $articleUuid,
        string $body,
        DateTimeImmutable $createdAt
    ) {
        $this->commentUuid = $commentUuid;
        $this->authorUuid = $authorUuid;
        $this->articleUuid = $articleUuid;
        $this->body = $body;
        $this->createdAt = $createdAt;
    }

    public function getCommentUuid(): CommentUuid
    {
        return $this->commentUuid;
    }

    public function getAuthorUuid(): AuthorUuid
    {
        return $this->authorUuid;
    }

    public function getArticleUuid(): ArticleUuid
    {
        return $this->articleUuid;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
