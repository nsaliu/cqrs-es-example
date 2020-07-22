<?php

declare(strict_types=1);

namespace App\User\Application\Console;

use App\Shared\Infrastructure\Bus\CommandBusInterface;
use App\User\Application\Command\RemoveAddressCommand;
use App\User\Domain\Address\AddressUuid;
use App\User\Domain\UserUuid;
use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class RemoveAddressFromUserConsoleCommand extends Command
{
    protected static $defaultName = 'app:user:remove-addresses';

    private CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('user-uuid', InputArgument::REQUIRED, 'The user uuid');

        $this->addArgument('addresses-uuid', InputArgument::REQUIRED, 'The addresses uuid');

        parent::configure();
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        $userUuid = $input->getArgument('user-uuid');

        if (!is_string($userUuid)) {
            throw new InvalidArgumentException('User uuid must be a string');
        }

        $addressUuid = $input->getArgument('addresses-uuid');

        if (!is_string($addressUuid)) {
            throw new InvalidArgumentException('Address uuid must be a string');
        }

        $this->commandBus->dispatch(
            new RemoveAddressCommand(
                UserUuid::fromString($userUuid),
                AddressUuid::fromString($addressUuid),
            )
        );

        $output->writeln('<info>Address removed from user</info>');

        return self::SUCCESS;
    }
}
