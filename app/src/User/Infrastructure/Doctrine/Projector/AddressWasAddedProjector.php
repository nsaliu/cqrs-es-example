<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Projector;

use App\User\Domain\Address\Address;
use App\User\Domain\Address\AddressUuid;
use App\User\Domain\Event\AddressWasAdded;
use App\User\Infrastructure\Doctrine\Repository\DoctrineUserRepository;
use EventSauce\EventSourcing\Consumer;
use Jphooiveld\Bundle\EventSauceBundle\ConsumableTrait;

final class AddressWasAddedProjector implements Consumer
{
    use ConsumableTrait;

    private DoctrineUserRepository $userRepository;

    public function __construct(DoctrineUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function applyAddressWasAddedProjector(AddressWasAdded $event): void
    {
        $user = $this->userRepository->findByUuid($event->getUserUuid());

        /**
         * todo:
         *  - add DoctrineAddress
         *  - reference it on DoctrineUser
         *  - add new Address to DoctrineUser and persist
         */
    }
}
