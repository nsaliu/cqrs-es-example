<?php

declare(strict_types=1);

namespace App\User\Application\Console;

use App\Shared\Infrastructure\Bus\CommandBusInterface;
use App\User\Application\Command\UpdateUserNameCommand;
use App\User\Domain\UserUuid;
use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class UpdateUserNameConsoleCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:user:update-name';

    private CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('user-uuid', InputArgument::REQUIRED, 'A valid user uuid');

        $this->addArgument('name', InputArgument::REQUIRED, 'The new user name');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $userUuid = $input->getArgument('user-uuid');

        if (!is_string($userUuid)) {
            throw new InvalidArgumentException('Uuid must be a string');
        }

        $name = $input->getArgument('name');

        if (!is_string($name)) {
            throw new InvalidArgumentException('Name must be a string');
        }

        $this->commandBus->dispatch(
            new UpdateUserNameCommand(
                UserUuid::fromString($userUuid),
                $name
            )
        );

        $output->writeln('<info>User name updated</info>');

        return self::SUCCESS;
    }
}
