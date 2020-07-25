<?php

declare(strict_types=1);

namespace App\User\Application\Console;

use App\Shared\Infrastructure\Bus\CommandBusInterface;
use App\User\Application\Command\UpdateUserNameCommand;
use App\User\Domain\UserUuid;
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

    protected function configure()
    {
        $this->addArgument('uuid', InputArgument::REQUIRED, 'A valid user uuid');

        $this->addArgument('name', InputArgument::REQUIRED, 'The new user name');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->commandBus->dispatch(
            new UpdateUserNameCommand(
                UserUuid::createFromString($input->getArgument('uuid')),
                $input->getArgument('name')
            )
        );

        $output->writeln('<info>User name updated</info>');

        return 0;
    }
}
