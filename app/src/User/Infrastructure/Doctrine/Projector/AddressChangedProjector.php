<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Projector;

use App\User\Domain\Event\AddressChanged;
use App\User\Infrastructure\Doctrine\Repository\DoctrineUserRepository;
use EventSauce\EventSourcing\Consumer;
use Jphooiveld\Bundle\EventSauceBundle\ConsumableTrait;

final class AddressChangedProjector implements Consumer
{
    use ConsumableTrait;

    private DoctrineUserRepository $userRepository;

    public function __construct(DoctrineUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function applyAddressChanged(AddressChanged $event): void
    {
        $user = $this->userRepository->findByUuid($event->getUserUuid());

        $user->updateAddress(
            $event->getOldAddressUuid(),
            $event->getNewAddressUuid(),
            $event->getNewStreetName(),
            $event->getNewStreetNumber()
        );

        $this->userRepository->persist($user);
        $this->userRepository->flush();
    }
}
