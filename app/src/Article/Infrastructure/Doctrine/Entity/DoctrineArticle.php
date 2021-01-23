<?php

declare(strict_types=1);

namespace App\Article\Infrastructure\Doctrine\Entity;

use App\Article\Domain\ArticleUuid;
use App\Article\Domain\AuthorUuid;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="projection_articles",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(
 *             name="uuid_unq",
 *             columns={"uuid"}
 *         )
 *     }
 * )
 */
class DoctrineArticle
{
    /**
     * @ORM\Id()
     * @ORM\Column(
     *     name="uuid",
     *     type="article_uuid",
     *     length=36
     * )
     */
    private ArticleUuid $articleUuid;

    /**
     * @ORM\Column(
     *     name="author_uuid",
     *     type="author_uuid",
     *     nullable=false,
     *     length=36
     * )
     */
    private AuthorUuid $authorUuid;

    /**
     * @ORM\Column(
     *     name="title",
     *     type="string",
     *     nullable=false
     * )
     */
    private string $title;

    /**
     * @ORM\Column(
     *     name="text",
     *     type="text",
     *     nullable=false
     * )
     */
    private string $text;

    /**
     * @ORM\Column(
     *     name="created_at",
     *     type="date_immutable",
     *     nullable=false
     * )
     */
    private DateTimeInterface $createdAt;

    public function __construct(
        ArticleUuid $articleUuid,
        AuthorUuid $authorUuid,
        string $title,
        string $text,
        DateTimeInterface $createdAt
    ) {
        $this->articleUuid = $articleUuid;
        $this->authorUuid = $authorUuid;
        $this->title = $title;
        $this->text = $text;
        $this->createdAt = $createdAt;
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

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }
}
