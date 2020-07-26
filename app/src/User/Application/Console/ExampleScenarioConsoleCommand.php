<?php

declare(strict_types=1);

namespace App\User\Application\Console;

use RuntimeException;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ExampleScenarioConsoleCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:scenario:create-example-scenario';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $userUuid = 'a0b32274-0dbb-47f0-bad5-3d059c3e0fd0';

        // empty tables
        $emptyTablesCommand = $this->getApp()->find('app:db:empty-tables');
        $emptyTablesCommand->run(
            new ArrayInput([]),
            $output
        );

        // register new user
        $registerUserCommand = $this->getApp()->find('app:user:register-new');
        $registerUserCommand->run(
            new ArrayInput([
                'uuid' => $userUuid,
                'name' => 'Nicola',
                'surname' => 'Saliu',
            ]),
            $output
        );

        // update user name
        $updateUserNameCommand = $this->getApp()->find('app:user:update-name');
        $updateUserNameCommand->run(
            new ArrayInput([
                'uuid' => $userUuid,
                'name' => 'Nico',
            ]),
            $output
        );

        // add first address
        $addFirstAddressCommand = $this->getApp()->find('app:user:add-addresses');
        $addFirstAddressCommand->run(
            new ArrayInput([
                'user-uuid' => $userUuid,
                'street-name' => 'Via Roma',
                'street-number' => 1,
            ]),
            $output
        );

        // add second address
        $addSecondAddressCommand = $this->getApp()->find('app:user:add-addresses');
        $addSecondAddressCommand->run(
            new ArrayInput([
                'user-uuid' => $userUuid,
                'street-name' => 'Via Milano',
                'street-number' => 2,
            ]),
            $output
        );

        // retrieve user data
        $retrieveUserDataCommand = $this->getApp()->find('app:user:get-by-uuid');
        $retrieveUserDataCommand->run(
            new ArrayInput([
                'uuid' => $userUuid,
            ]),
            $output
        );

        return self::SUCCESS;
    }

    private function getApp(): Application
    {
        $application = $this->getApplication();

        if ($application === null) {
            throw new RuntimeException('Application is null');
        }

        return $application;
    }
}
