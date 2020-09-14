<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\User\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

final class UpdateUserNameCommandHandler implements MessageSubscriberInterface
{
    private UserRepositoryInterface $userEventRepository;

    public function __construct(UserRepositoryInterface $userEventRepository)
    {
        $this->userEventRepository = $userEventRepository;
    }

    public function __invoke(UpdateUserNameCommand $command): void
    {
        $user = $this->userEventRepository->get($command->getAggregateUuid());

        $user->updateName(
            $command->getAggregateUuid(),
            $command->getName()
        );

        $this->userEventRepository->save($user);
    }

    /**
     * @return iterable<string>
     */
    public static function getHandledMessages(): iterable
    {
        yield UpdateUserNameCommand::class;
    }
}
