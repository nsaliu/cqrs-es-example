<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\User\Domain\Repository\UserRepositoryInterface;
use App\User\Domain\User;
use App\User\Domain\UserUuid;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

final class RegisterUserCommandHandler implements MessageSubscriberInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(RegisterUserCommand $command)
    {
        $user = new User(
            UserUuid::createNew(),
            $command->getName(),
            $command->getSurname()
        );

        $this->userRepository->save($user);
    }

    public static function getHandledMessages(): iterable
    {
        yield RegisterUserCommand::class;
    }
}
