<?php

declare(strict_types=1);

namespace App\User\Application\Console;

use App\Shared\Infrastructure\Bus\CommandBusInterface;
use App\User\Application\Command\AddAddressCommand;
use App\User\Domain\UserUuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class AddAddressToUserConsoleCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:user:add-addresses';

    private CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;

        parent::__construct();
    }

    protected function configure()
    {
        $this->addArgument('user-uuid', InputArgument::REQUIRED, 'A valid user uuid');

        $this->addArgument('street-name', InputArgument::REQUIRED, 'An addresses street name');

        $this->addArgument('streetNumber', InputArgument::REQUIRED, 'An addresses street streetNumber');

        parent::configure();
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $this->commandBus->dispatch(
            new AddAddressCommand(
                UserUuid::fromString($input->getArgument('user-uuid')),
                $input->getArgument('street-name'),
                (int) $input->getArgument('streetNumber'),
            )
        );

        $output->writeln('<info>Address added to user</info>');

        return self::SUCCESS;
    }
}
