<?php

declare(strict_types=1);

namespace App\Article\Application\Console;

use App\Article\Application\Query\GetArticleByUuidQuery;
use App\Article\Domain\ArticleUuid;
use App\Shared\Infrastructure\Bus\QueryBusInterface;
use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class GetArticleByUuidConsoleCommand extends Command
{
    protected static $defaultName = 'app:article:get-by-uuid';

    private QueryBusInterface $queryBus;

    public function __construct(QueryBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('article-uuid', InputArgument::REQUIRED, 'The article uuid');
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $articleUuid = $input->getArgument('article-uuid');

        if (!is_string($articleUuid)) {
            throw new InvalidArgumentException('Article uuid must be a string');
        }

        $article = $this->queryBus->dispatch(
            new GetArticleByUuidQuery(
                ArticleUuid::fromString($articleUuid)
            )
        );

        dump($article);

        return self::SUCCESS;
    }
}
