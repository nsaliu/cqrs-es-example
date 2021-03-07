<?php

declare(strict_types=1);

namespace App\Article\Application\Console;

use App\Article\Application\Command\DeleteCommentCommand;
use App\Article\Domain\ArticleUuid;
use App\Article\Domain\AuthorUuid;
use App\Article\Domain\CommentUuid;
use App\Shared\Infrastructure\Bus\CommandBusInterface;
use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class DeleteCommentConsoleCommand extends Command
{
    protected static $defaultName = 'app:comment:delete';

    private CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('article-uuid', InputArgument::REQUIRED, 'The article uuid');

        $this->addArgument('comment-uuid', InputArgument::REQUIRED, 'The comment uuid');

        $this->addArgument('author-uuid', InputArgument::REQUIRED, 'The author uuid');
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $articleUuid = $input->getArgument('article-uuid');

        if (!is_string($articleUuid)) {
            throw new InvalidArgumentException('Article uuid must be a string');
        }

        $commentUuid = $input->getArgument('comment-uuid');

        if (!is_string($commentUuid)) {
            throw new InvalidArgumentException('Comment uuid must be a string');
        }

        $authorUuid = $input->getArgument('author-uuid');

        if (!is_string($authorUuid)) {
            throw new InvalidArgumentException('Author uuid must be a string');
        }

        $this->commandBus->dispatch(
            new DeleteCommentCommand(
                ArticleUuid::fromString($articleUuid),
                CommentUuid::fromString($commentUuid),
                AuthorUuid::fromString($authorUuid)
            )
        );

        $output->writeln('<info>Comment deleted successfully.</info>');

        return self::SUCCESS;
    }
}
