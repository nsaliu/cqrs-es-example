<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Projector;

use App\User\Domain\Event\AddressAdded;
use App\User\Infrastructure\Doctrine\Repository\DoctrineUserRepository;
use EventSauce\EventSourcing\Consumer;
use Jphooiveld\Bundle\EventSauceBundle\ConsumableTrait;

final class AddressAddedProjector implements Consumer
{
    use ConsumableTrait;

    private DoctrineUserRepository $userRepository;

    public function __construct(DoctrineUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function applyAddressAdded(AddressAdded $event): void
    {
        $user = $this->userRepository->findByUuid($event->getUserUuid());

        if ($user->getAddress1Uuid() === null) {
            $user->updateAddress1(
                $event->getAddressUuid(),
                $event->getStreetName(),
                $event->getStreetNumber()
            );

            $this->userRepository->persist($user);
            $this->userRepository->flush();

            return;
        }

        if ($user->getAddress2Uuid() === null) {
            $user->updateAddress2(
                $event->getAddressUuid(),
                $event->getStreetName(),
                $event->getStreetNumber()
            );

            $this->userRepository->persist($user);
            $this->userRepository->flush();
        }
    }
}
