<?php

declare(strict_types=1);

namespace App\Article\Infrastructure\Doctrine\Projector;

use App\Article\Domain\Event\CommentDeleted;
use App\Article\Infrastructure\Doctrine\Repository\DoctrineCommentRepository;
use EventSauce\EventSourcing\Consumer;
use Jphooiveld\Bundle\EventSauceBundle\ConsumableTrait;

final class CommentDeletedProjector implements Consumer
{
    use ConsumableTrait;

    private DoctrineCommentRepository $commentRepository;

    public function __construct(DoctrineCommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function applyCommentDeleted(CommentDeleted $event): void
    {
        $comment = $this->commentRepository->findByUuid($event->getCommentUuid());

        $this->commentRepository->remove($comment);
        $this->commentRepository->flush();
    }
}
