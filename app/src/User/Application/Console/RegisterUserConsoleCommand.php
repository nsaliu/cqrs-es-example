<?php

declare(strict_types=1);

namespace App\User\Application\Console;

use App\User\Application\Command\RegisterUserCommand;
use App\Shared\Infrastructure\Bus\CommandBusInterface;
use App\User\Domain\UserUuid;
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
        $this->addArgument('name', InputArgument::REQUIRED, 'The user name');

        $this->addArgument('surname', InputArgument::REQUIRED, 'The user surname');

        parent::configure();
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $this->commandBus->dispatch(
            new RegisterUserCommand(
                UserUuid::createNew(),
                $input->getArgument('name'),
                $input->getArgument('surname'),
            )
        );

        $output->writeln('<info>User registered</info>');

        return 0;
    }
}
