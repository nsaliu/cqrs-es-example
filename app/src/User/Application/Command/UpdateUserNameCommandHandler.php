<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\User\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

final class UpdateUserNameCommandHandler implements MessageSubscriberInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(UpdateUserNameCommand $command)
    {
        $user = $this->userRepository->get($command->getUserUuid());

        $user->updateName($command->getUserName());

        $this->userRepository->update($user);
    }

    public static function getHandledMessages(): iterable
    {
        yield UpdateUserNameCommand::class;
    }
}
