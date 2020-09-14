<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\User\Domain\Address\AddressUuid;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\User\Domain\UserId;
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
        /** @var UserId $userUuid */
        $userUuid = $command->getAggregateUuid();

        $user = $this->userEventRepository->get($userUuid);

        $user->addAddress(
            $userUuid,
            AddressUuid::createNew(),
            $command->getStreetName(),
            $command->getStreetNumber()
        );

        $this->userEventRepository->save($user);
    }

    /**
     * @return iterable<string>
     */
    public static function getHandledMessages(): iterable
    {
        yield AddAddressCommand::class;
    }
}
