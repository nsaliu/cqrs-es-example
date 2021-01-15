<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\User\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

final class ChangeUserAddressCommandHandler implements MessageSubscriberInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(ChangeUserAddressCommand $command): void
    {
        $user = $this->userRepository->get($command->getAggregateUuid());

        $user->changeAddress(
            $command->getAggregateUuid(),
            $command->getOldAddressUuid(),
            $command->getOldStreetName(),
            $command->getOldStreetNumber(),
            $command->getNewAddressUuid(),
            $command->getNewStreetName(),
            $command->getNewStreetNumber()
        );

        $this->userRepository->save($user);
    }

    /**
     * @return iterable<string>
     */
    public static function getHandledMessages(): iterable
    {
        yield ChangeUserAddressCommand::class;
    }
}
