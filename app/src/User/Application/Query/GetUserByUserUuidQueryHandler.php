<?php

declare(strict_types=1);

namespace App\User\Application\Query;

use App\User\Domain\Repository\UserRepositoryInterface;
use App\User\Domain\User;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

final class GetUserByUserUuidQueryHandler implements MessageSubscriberInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(GetUserByUserUuidQuery $query): User
    {
        return $this->userRepository->get($query->getUserUuid());
    }

    public static function getHandledMessages(): iterable
    {
        yield GetUserByUserUuidQuery::class;
    }
}
