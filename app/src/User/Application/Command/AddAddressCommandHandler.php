<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\User\Domain\Address\AddressUuid;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\User\Domain\Service\AddressDomainService;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

final class AddAddressCommandHandler implements MessageSubscriberInterface
{
    private UserRepositoryInterface $userEventRepository;

    private AddressDomainService $addressDomainService;

    public function __construct(
        UserRepositoryInterface $userEventRepository,
        AddressDomainService $addressDomainService
    ) {
        $this->userEventRepository = $userEventRepository;
        $this->addressDomainService = $addressDomainService;
    }

    public function __invoke(AddAddressCommand $command): void
    {
        $userUuid = $command->getAggregateUuid();

        $user = $this->userEventRepository->get($userUuid);

        $user->addAddress(
            $userUuid,
            AddressUuid::createNew(),
            $command->getStreetName(),
            $command->getStreetNumber(),
            $this->addressDomainService
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
