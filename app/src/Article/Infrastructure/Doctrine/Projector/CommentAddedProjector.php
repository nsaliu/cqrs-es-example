<?php

declare(strict_types=1);

namespace App\Article\Infrastructure\Doctrine\Projector;

use App\Article\Domain\Event\CommentAdded;
use App\Article\Infrastructure\Doctrine\Entity\DoctrineComment;
use App\Article\Infrastructure\Doctrine\Repository\DoctrineCommentRepository;
use EventSauce\EventSourcing\Consumer;
use Jphooiveld\Bundle\EventSauceBundle\ConsumableTrait;

final class CommentAddedProjector implements Consumer
{
    use ConsumableTrait;

    private DoctrineCommentRepository $commentRepository;

    public function __construct(DoctrineCommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function applyCommentAdded(CommentAdded $event): void
    {
        $comment = new DoctrineComment(
            $event->getCommentUuid(),
            $event->getAuthorUuid(),
            $event->getArticleUuid(),
            $event->getText(),
            $event->getCreatedAt()
        );

        $this->commentRepository->persist($comment);
        $this->commentRepository->flush();
    }
}
