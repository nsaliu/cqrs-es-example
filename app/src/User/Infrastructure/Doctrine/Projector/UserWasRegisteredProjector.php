<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Projector;

use App\User\Domain\Event\UserWasRegistered;
use App\User\Infrastructure\Doctrine\Entity\DoctrineUser;
use App\User\Infrastructure\Doctrine\Repository\DoctrineUserRepository;
use EventSauce\EventSourcing\Consumer;
use Jphooiveld\Bundle\EventSauceBundle\ConsumableTrait;

final class UserWasRegisteredProjector implements Consumer
{
    use ConsumableTrait;

    private DoctrineUserRepository $userRepository;

    public function __construct(DoctrineUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function applyUserWasRegistered(UserWasRegistered $event): void
    {
        $user = new DoctrineUser(
            $event->getUserUuid(),
            $event->getName(),
            $event->getSurname(),
            null,
            null,
            null,
            null,
            null,
            null,
            new \DateTimeImmutable()
        );

        $this->userRepository->persist($user);
        $this->userRepository->flush();
    }
}
