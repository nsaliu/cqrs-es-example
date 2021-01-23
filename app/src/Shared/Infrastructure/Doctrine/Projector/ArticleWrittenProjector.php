<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine\Projector;

use App\Article\Domain\Event\ArticleWritten;
use App\Article\Infrastructure\Doctrine\Entity\DoctrineArticle;
use App\Article\Infrastructure\Doctrine\Repository\DoctrineArticleRepository;
use App\User\Domain\UserUuid;
use App\User\Infrastructure\Doctrine\Repository\DoctrineUserRepository;
use EventSauce\EventSourcing\Consumer;
use Jphooiveld\Bundle\EventSauceBundle\ConsumableTrait;

final class ArticleWrittenProjector implements Consumer
{
    use ConsumableTrait;

    private DoctrineArticleRepository $articleRepository;

    private DoctrineUserRepository $userRepository;

    public function __construct(
        DoctrineArticleRepository $articleRepository,
        DoctrineUserRepository $userRepository
    ) {
        $this->articleRepository = $articleRepository;
        $this->userRepository = $userRepository;
    }

    public function applyArticleWritten(ArticleWritten $event): void
    {
        $author = $this->userRepository->findByUuid(
            UserUuid::fromString($event->getAuthorUuid()->toString())
        );

        $article = new DoctrineArticle(
            $event->getArticleUuid(),
            $event->getAuthorUuid(),
            $author->getName(),
            $author->getSurname(),
            $event->getTitle(),
            $event->getText(),
            $event->getOccurredAt()
        );

        $this->articleRepository->persist($article);
        $this->articleRepository->flush();
    }
}
