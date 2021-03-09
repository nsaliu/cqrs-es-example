<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Repository;

use App\User\Domain\Exception\UserNotFoundByUuidException;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\User\Domain\User;
use App\User\Domain\UserUuid;
use App\User\Infrastructure\Doctrine\Entity\DoctrineUser;
use App\User\Infrastructure\Translator\UserTranslator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    private UserTranslator $userTranslator;

    public function __construct(
        ManagerRegistry $registry,
        UserTranslator $userTranslator
    ) {
        $this->userTranslator = $userTranslator;

        parent::__construct(
            $registry,
            DoctrineUser::class
        );
    }

    public function get(UserUuid $userId): User
    {
        /** @var DoctrineUser|null $doctrineUser */
        $doctrineUser = $this->findOneBy([
            'userUuid' => $userId,
        ]);

        if ($doctrineUser === null) {
            throw new UserNotFoundByUuidException($userId);
        }

        return $this->userTranslator->fromDoctrineEntityToDomainModel($doctrineUser);
    }

    public function save(User $user): void
    {
        $doctrineUser = $this->userTranslator->fromDomainModelToDoctrineEntity($user);

        $this->getEntityManager()->persist($doctrineUser);
        $this->getEntityManager()->flush();
    }

    public function update(User $user): void
    {
        /** @var DoctrineUser|null $doctrineUser */
        $doctrineUser = $this->findOneBy([
            'userUuid' => $user->getUserUuid()
        ]);

        if ($doctrineUser === null) {
            throw new UserNotFoundByUuidException($user->getUserUuid());
        }

        $doctrineUser->setName($user->getName());
        $doctrineUser->setSurname($user->getSurname());

        $this->getEntityManager()->persist($doctrineUser);
        $this->getEntityManager()->flush();
    }
}
