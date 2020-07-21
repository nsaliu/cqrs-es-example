<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\User\Domain\Event\RegisterNewUser;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\User\Domain\User;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

final class RegisterUserCommandHandler implements MessageSubscriberInterface
{
    private UserRepositoryInterface $userEventRepository;

    public function __construct(UserRepositoryInterface $userEventRepository)
    {
        $this->userEventRepository = $userEventRepository;
    }

    public function __invoke(RegisterUserCommand $command)
    {
        $user = User::create($command->getUuid());

        $user->registerUser(
            new RegisterNewUser(
                $command->getName(),
                $command->getSurname()
            )
        );

        $this->userEventRepository->save($user);
    }

    public static function getHandledMessages(): iterable
    {
        yield RegisterUserCommand::class;
    }
}
