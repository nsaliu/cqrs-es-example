<?php

declare(strict_types=1);

namespace App\User\Application\Command;

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

    public function __invoke(RegisterUserCommand $command): void
    {
        $user = User::create($command->getUuid());

        $user->registerUser(
            $command->getUuid(),
            $command->getName(),
            $command->getSurname()
        );

        $this->userEventRepository->save($user);
    }

    /**
     * @return iterable<string>
     */
    public static function getHandledMessages(): iterable
    {
        yield RegisterUserCommand::class;
    }
}
