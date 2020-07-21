<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\User\Domain\Event\UpdateUserName;
use App\User\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

final class UpdateUserNameCommandHandler implements MessageSubscriberInterface
{
    private UserRepositoryInterface $userEventRepository;

    public function __construct(UserRepositoryInterface $userEventRepository)
    {
        $this->userEventRepository = $userEventRepository;
    }

    public function __invoke(UpdateUserNameCommand $command)
    {
        $user = $this->userEventRepository->get($command->getUuid());

        $user->updateName(new UpdateUserName($command->getName())
        );

        $this->userEventRepository->save($user);
    }

    public static function getHandledMessages(): iterable
    {
        yield UpdateUserNameCommand::class;
    }
}
