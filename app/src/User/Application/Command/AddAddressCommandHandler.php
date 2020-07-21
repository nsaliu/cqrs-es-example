<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\User\Domain\Address\AddressUuid;
use App\User\Domain\Event\AddAddress;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\User\Domain\UserUuid;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

final class AddAddressCommandHandler implements MessageSubscriberInterface
{
    private UserRepositoryInterface $userEventRepository;

    public function __construct(UserRepositoryInterface $userEventRepository)
    {
        $this->userEventRepository = $userEventRepository;
    }

    public function __invoke(AddAddressCommand $command): void
    {
        /** @var UserUuid $userUuid */
        $userUuid = $command->getUuid();

        $user = $this->userEventRepository->get($userUuid);

        $user->addAddress(
            new AddAddress(
                $userUuid,
                AddressUuid::createNew(),
                $command->getStreetName(),
                $command->getStreetNumber()
            )
        );

        $this->userEventRepository->save($user);
    }

    public static function getHandledMessages(): iterable
    {
        yield AddAddressCommand::class;
    }
}
