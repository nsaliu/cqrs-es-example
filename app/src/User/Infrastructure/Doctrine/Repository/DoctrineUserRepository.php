<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Repository;

use App\User\Domain\UserUuid;
use App\User\Infrastructure\Doctrine\Entity\DoctrineUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class DoctrineUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoctrineUser::class);
    }

    public function findByUuid(UserUuid $userUuid): DoctrineUser
    {
        /** @var DoctrineUser $user */
        $user = $this->findOneBy([
            'userUuid' => $userUuid,
        ]);

        return $user;
    }

    public function persist(DoctrineUser $user): void
    {
        $this->getEntityManager()->persist($user);
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }
}
