<?php

declare(strict_types=1);

namespace App\User\Application\Console;

use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class EmptyTablesConsoleCommand extends Command
{
    protected static $defaultName = 'app:db:empty-tables';

    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->connection->executeUpdate('TRUNCATE TABLE events');
        $this->connection->executeUpdate('TRUNCATE TABLE projection_users');

        $output->writeln('<info>Tables are now empty</info>');

        return self::SUCCESS;
    }
}
