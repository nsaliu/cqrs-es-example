<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Projector;

use App\User\Domain\Event\UserNameWasUpdated;
use App\User\Infrastructure\Doctrine\Repository\DoctrineUserRepository;
use EventSauce\EventSourcing\Consumer;
use Jphooiveld\Bundle\EventSauceBundle\ConsumableTrait;

final class UserNameWasUpdatedProjector implements Consumer
{
    use ConsumableTrait;

    private DoctrineUserRepository $userRepository;

    public function __construct(DoctrineUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function applyUserNameWasUpdated(UserNameWasUpdated $event): void
    {
        $user = $this->userRepository->findByUuid($event->getUserUuid());

        $user->updateName($event->getName());

        $this->userRepository->persist($user);
        $this->userRepository->flush();
    }
}
