<?php

declare(strict_types=1);

namespace App\Article\Infrastructure\Doctrine\Repository;

use App\Article\Domain\CommentUuid;
use App\Article\Infrastructure\Doctrine\Entity\DoctrineComment;
use App\Article\Infrastructure\Doctrine\Exception\CommentNotFoundByUuidException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class DoctrineCommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoctrineComment::class);
    }

    public function findByUuid(CommentUuid $commentUuid): DoctrineComment
    {
        /** @var DoctrineComment|null $comment */
        $comment = $this->findOneBy([
            'commentUuid' => $commentUuid,
        ]);

        if ($comment === null) {
            throw new CommentNotFoundByUuidException($commentUuid);
        }

        return $comment;
    }

    public function persist(DoctrineComment $comment): void
    {
        $this->getEntityManager()->persist($comment);
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }
}
