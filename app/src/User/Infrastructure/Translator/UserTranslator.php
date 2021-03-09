<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Translator;

use App\User\Domain\User;
use App\User\Infrastructure\Doctrine\Entity\DoctrineUser;
use AutoMapperPlus\AutoMapperInterface;
use AutoMapperPlus\AutoMapperPlusBundle\AutoMapperConfiguratorInterface;
use AutoMapperPlus\Configuration\AutoMapperConfigInterface;
use DateTimeImmutable;

final class UserTranslator implements AutoMapperConfiguratorInterface
{
    private AutoMapperInterface $mapper;

    public function __construct(AutoMapperInterface $mapper)
    {
        $this->mapper = $mapper;
    }

    public function configure(AutoMapperConfigInterface $config): void
    {
        $config->registerMapping(
            User::class,
            DoctrineUser::class
        )->forMember(
            'createdAt',
            fn (User $user): DateTimeImmutable => new DateTimeImmutable()
        );

        $config->registerMapping(
            DoctrineUser::class,
            User::class
        );
    }

    public function fromDoctrineEntityToDomainModel(DoctrineUser $doctrineUser): User
    {
        return $this->mapper->map($doctrineUser, User::class);
    }

    public function fromDomainModelToDoctrineEntity(User $user): DoctrineUser
    {
        return $this->mapper->map($user, DoctrineUser::class);
    }
}
