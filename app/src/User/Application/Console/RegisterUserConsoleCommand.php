<?php

declare(strict_types=1);

namespace App\User\Application\Console;

use App\Shared\Infrastructure\Bus\CommandBusInterface;
use App\User\Application\Command\RegisterUserCommand;
use App\User\Domain\UserUuid;
use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class RegisterUserConsoleCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:user:register-new';

    private CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('uuid', InputArgument::REQUIRED, 'The user uuid');

        $this->addArgument('name', InputArgument::REQUIRED, 'The user name');

        $this->addArgument('surname', InputArgument::REQUIRED, 'The user surname');

        parent::configure();
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $userUuid = $input->getArgument('uuid');

        if (!is_string($userUuid)) {
            throw new InvalidArgumentException('User uuid must be a string');
        }

        $name = $input->getArgument('name');

        if (!is_string($name)) {
            throw new InvalidArgumentException('User name must be a string');
        }

        $surname = $input->getArgument('surname');

        if (!is_string($surname)) {
            throw new InvalidArgumentException('User surname must be a string');
        }

        $this->commandBus->dispatch(
            new RegisterUserCommand(
                UserUuid::fromString($userUuid),
                $name,
                $surname,
            )
        );

        $output->writeln('<info>User registered</info>');

        return self::SUCCESS;
    }
}
