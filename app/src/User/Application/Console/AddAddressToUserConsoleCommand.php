<?php

declare(strict_types=1);

namespace App\User\Application\Console;

use App\Shared\Infrastructure\Bus\CommandBusInterface;
use App\User\Application\Command\AddAddressCommand;
use App\User\Domain\UserId;
use InvalidArgumentException;
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

    protected function configure(): void
    {
        $this->addArgument('user-uuid', InputArgument::REQUIRED, 'A valid user uuid');

        $this->addArgument('street-name', InputArgument::REQUIRED, 'An addresses street name');

        $this->addArgument('street-number', InputArgument::REQUIRED, 'An addresses street streetNumber');

        parent::configure();
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $userUuid = $input->getArgument('user-uuid');

        if (!is_string($userUuid)) {
            throw new InvalidArgumentException('User uuid must be a string');
        }

        $streetName = $input->getArgument('street-name');

        if (!is_string($streetName)) {
            throw new InvalidArgumentException('Street name must be a string');
        }

        $streetNumber = $input->getArgument('street-number');

        if ($streetNumber === null || is_array($streetNumber)) {
            throw new InvalidArgumentException('Street number must be an integer');
        }

        $this->commandBus->dispatch(
            new AddAddressCommand(
                UserId::fromString($userUuid),
                $streetName,
                (int) $streetNumber
            )
        );

        $output->writeln('<info>Address added to user</info>');

        return self::SUCCESS;
    }
}
