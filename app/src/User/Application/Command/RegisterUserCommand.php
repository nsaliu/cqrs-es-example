<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\User\Domain\UserUuid;

final class RegisterUserCommand implements CommandInterface
{
    private UserUuid $uuid;

    private string $name;

    private string $surname;

    public function __construct(
        UserUuid $uuid,
        string $name,
        string $surname
    ) {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->surname = $surname;
    }

    public function getUuid(): UserUuid
    {
        return $this->uuid;
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
