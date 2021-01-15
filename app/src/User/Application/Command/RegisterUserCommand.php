<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\User\Domain\UserUuid;

final class RegisterUserCommand implements CommandInterface
{
    private UserUuid $userUuid;

    private string $name;

    private string $surname;

    public function __construct(
        UserUuid $userUuid,
        string $name,
        string $surname
    ) {
        $this->userUuid = $userUuid;
        $this->name = $name;
        $this->surname = $surname;
    }

    public function getAggregateUuid(): UserUuid
    {
        return $this->userUuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }
}
