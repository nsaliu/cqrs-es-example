<?php

declare(strict_types=1);

namespace App\User\Domain;

use App\User\Domain\Exception\UserNamePropertyIsTooShort;

final class User
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

    public function getUserUuid(): UserUuid
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

    public function updateName(string $name): void
    {
        if (mb_strlen($name) === 0) {
            throw new UserNamePropertyIsTooShort();
        }

        $this->name = $name;
    }
}
