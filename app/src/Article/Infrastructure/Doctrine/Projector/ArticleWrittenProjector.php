<?php

declare(strict_types=1);

namespace App\Article\Infrastructure\Doctrine\Projector;

use App\Article\Domain\Event\ArticleWritten;
use App\Article\Infrastructure\Doctrine\Entity\DoctrineArticle;
use App\Article\Infrastructure\Doctrine\Repository\DoctrineArticleRepository;
use EventSauce\EventSourcing\Consumer;
use Jphooiveld\Bundle\EventSauceBundle\ConsumableTrait;

final class ArticleWrittenProjector implements Consumer
{
    use ConsumableTrait;

    private DoctrineArticleRepository $articleRepository;

    public function __construct(DoctrineArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function applyArticleWritten(ArticleWritten $event): void
    {
        $article = new DoctrineArticle(
            $event->getArticleUuid(),
            $event->getAuthorUuid(),
            $event->getTitle(),
            $event->getText(),
            $event->getOccurredAt()
        );

        $this->articleRepository->persist($article);
        $this->articleRepository->flush();
    }
}
