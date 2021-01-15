<?php

declare(strict_types=1);

namespace App\User\Application\Console;

use App\Shared\Infrastructure\Bus\CommandBusInterface;
use App\User\Application\Command\ChangeUserAddressCommand;
use App\User\Domain\Address\AddressUuid;
use App\User\Domain\UserId;
use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ChangeUserAddressConsoleCommand extends Command
{
    protected static $defaultName = 'app:user:change-address';

    private CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('user-uuid', InputArgument::REQUIRED, 'The user uuid');

        $this->addArgument('old-address-uuid', InputArgument::REQUIRED, 'The old address uuid');

        $this->addArgument('old-address-street-name', InputArgument::REQUIRED, 'The old address street name');

        $this->addArgument('old-address-street-number', InputArgument::REQUIRED, 'The old address street number');

        $this->addArgument('new-address-uuid', InputArgument::REQUIRED, 'The new address uuid');

        $this->addArgument('new-address-street-name', InputArgument::REQUIRED, 'The new address street name');

        $this->addArgument('new-address-street-number', InputArgument::REQUIRED, 'The new address street number');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $userUuid = $input->getArgument('user-uuid');

        if (!is_string($userUuid)) {
            throw new InvalidArgumentException('User uuid must be a string');
        }

        $oldAddressUuid = $input->getArgument('old-address-uuid');

        if (!is_string($oldAddressUuid)) {
            throw new InvalidArgumentException('Old address uuid must be a string');
        }

        $oldAddressStreetName = $input->getArgument('old-address-street-name');

        if (!is_string($oldAddressStreetName)) {
            throw new InvalidArgumentException('Old address street name must be a string');
        }

        $oldAddressStreetNumber = $input->getArgument('old-address-street-number');

        if ($oldAddressStreetNumber === null || is_array($oldAddressStreetNumber)) {
            throw new InvalidArgumentException('Old address street number must be an integer');
        }

        $newAddressUuid = $input->getArgument('new-address-uuid');

        if (!is_string($newAddressUuid)) {
            throw new InvalidArgumentException('New address uuid must be a string');
        }

        $newAddressStreetName = $input->getArgument('new-address-street-name');

        if (!is_string($newAddressStreetName)) {
            throw new InvalidArgumentException('New address street name must be a string');
        }

        $newAddressStreetNumber = $input->getArgument('new-address-street-number');

        if ($newAddressStreetNumber === null || is_array($newAddressStreetNumber)) {
            throw new InvalidArgumentException('New address street number must be an integer');
        }

        $this->commandBus->dispatch(
            new ChangeUserAddressCommand(
                UserId::fromString($userUuid),
                AddressUuid::fromString($oldAddressUuid),
                $oldAddressStreetName,
                (int) $oldAddressStreetNumber,
                AddressUuid::fromString($newAddressUuid),
                $newAddressStreetName,
                (int) $newAddressStreetNumber
            )
        );

        $output->writeln('<info>User address changed</info>');

        return self::SUCCESS;
    }
}
