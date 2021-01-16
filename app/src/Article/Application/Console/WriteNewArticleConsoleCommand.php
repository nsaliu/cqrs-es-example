<?php

declare(strict_types=1);

namespace App\Article\Application\Console;

use App\Article\Application\Command\WriteNewArticleCommand;
use App\Article\Domain\ArticleUuid;
use App\Shared\Infrastructure\Bus\CommandBusInterface;
use App\Shared\Infrastructure\Uuid\GenericUuid;
use InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class WriteNewArticleConsoleCommand extends Command
{
    protected static $defaultName = 'app:article:write-new-article';

    private CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('author-uuid', InputArgument::REQUIRED, 'The author uuid');

        $this->addArgument('title', InputArgument::REQUIRED, 'The article title');

        $this->addArgument('text', InputArgument::REQUIRED, 'The article text');
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $authorUuid = $input->getArgument('author-uuid');

        if (!is_string($authorUuid)) {
            throw new InvalidArgumentException('Author uuid must be a string');
        }

        $title = $input->getArgument('title');

        if (!is_string($title)) {
            throw new InvalidArgumentException('Article title must be a string');
        }

        $text = $input->getArgument('text');

        if (!is_string($text)) {
            throw new InvalidArgumentException('Article text must be a string');
        }

        $this->commandBus->dispatch(
            new WriteNewArticleCommand(
                ArticleUuid::fromString(Uuid::uuid4()->toString()),
                GenericUuid::fromString($authorUuid),
                $title,
                $text
            )
        );

        $output->writeln('<info>Article created successfully.</info>');

        return self::SUCCESS;
    }
}
