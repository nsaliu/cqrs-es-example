<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Projector;

use App\User\Domain\Event\AddressWasRemoved;
use App\User\Infrastructure\Doctrine\Repository\DoctrineUserRepository;
use EventSauce\EventSourcing\Consumer;
use Jphooiveld\Bundle\EventSauceBundle\ConsumableTrait;

final class AddressWasRemovedProjector implements Consumer
{
    use ConsumableTrait;

    private DoctrineUserRepository $userRepository;

    public function __construct(DoctrineUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function applyAddressWasRemoved(AddressWasRemoved $event): void
    {
        $user = $this->userRepository->findByUuid($event->getUserUuid());

        if ($user->getAddress1Uuid() !== null && $user->getAddress1Uuid()->equalsTo($event->getAddressUuid())) {
            $user->removeAddress1();
        }

        if ($user->getAddress2Uuid() !== null && $user->getAddress2Uuid()->equalsTo($event->getAddressUuid())) {
            $user->removeAddress2();
        }

        $this->userRepository->persist($user);
        $this->userRepository->flush();
    }
}
