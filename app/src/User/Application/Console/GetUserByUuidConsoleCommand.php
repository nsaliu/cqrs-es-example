<?php

declare(strict_types=1);

namespace App\User\Application\Console;

use App\Shared\Infrastructure\Bus\QueryBusInterface;
use App\User\Application\Query\GetUserByUserUuidQuery;
use App\User\Domain\UserUuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class GetUserByUuidConsoleCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:user:get-by-uuid';

    private QueryBusInterface $queryBus;

    public function __construct(QueryBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('uuid', InputArgument::REQUIRED, 'A valid user uuid');

        parent::configure();
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $userUuid = UserUuid::fromString($input->getArgument('uuid'));

        $user = $this->queryBus->dispatch(
            new GetUserByUserUuidQuery($userUuid)
        );

        $output->writeln(
            sprintf(
                '<info>User with uuid %s retrieved</info>',
                $userUuid
            )
        );

        dump($user);

        return self::SUCCESS;
    }
}
