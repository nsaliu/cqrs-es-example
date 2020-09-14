<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Repository;

use App\User\Domain\Repository\UserRepositoryInterface;
use App\User\Domain\User;
use App\User\Domain\UserId;
use EventSauce\EventSourcing\AggregateRootRepository;

final class UserAggregateRepository implements UserRepositoryInterface
{
    private AggregateRootRepository $aggregateRootRepository;

    public function __construct(
        AggregateRootRepository $aggregateRootRepository
    ) {
        $this->aggregateRootRepository = $aggregateRootRepository;
    }

    public function save(User $user): void
    {
        $this->aggregateRootRepository->persist($user);
    }

    public function get(UserId $userUuid): User
    {
        /** @var User $user */
        $user = $this->aggregateRootRepository->retrieve($userUuid);

        return $user;
    }
}
