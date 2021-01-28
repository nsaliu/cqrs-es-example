<?php

declare(strict_types=1);

namespace App\Article\Application\Console;

use App\Article\Application\Command\AddCommentCommand;
use App\Article\Domain\ArticleUuid;
use App\Article\Domain\AuthorUuid;
use App\Article\Domain\CommentUuid;
use App\Shared\Infrastructure\Bus\CommandBusInterface;
use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class AddCommentConsoleCommand extends Command
{
    protected static $defaultName = 'app:comment:add-new-comment';

    private CommandBusInterface $commandBus;

    private CommentUuid $commentUuid;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;

        $this->commentUuid = CommentUuid::createNew();

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('article-uuid', InputArgument::REQUIRED, 'The article uuid');

        $this->addArgument('author-uuid', InputArgument::REQUIRED, 'The author uuid');

        $this->addArgument('text', InputArgument::REQUIRED, 'The article text');
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $articleUuid = $input->getArgument('article-uuid');

        if (!is_string($articleUuid)) {
            throw new InvalidArgumentException('Article uuid must be a string');
        }

        $authorUuid = $input->getArgument('author-uuid');

        if (!is_string($authorUuid)) {
            throw new InvalidArgumentException('Author uuid must be a string');
        }

        $text = $input->getArgument('text');

        if (!is_string($text)) {
            throw new InvalidArgumentException('Article text must be a string');
        }

        $this->commandBus->dispatch(
            new AddCommentCommand(
                $this->commentUuid,
                ArticleUuid::fromString($articleUuid),
                AuthorUuid::fromString($authorUuid),
                $text
            )
        );

        $output->writeln('<info>Comment added successfully.</info>');

        return self::SUCCESS;
    }
}
