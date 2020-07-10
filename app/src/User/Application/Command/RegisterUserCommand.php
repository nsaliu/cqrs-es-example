<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\User\Domain\UserUuid;

final class RegisterUserCommand implements CommandInterface
{
    private UserUuid $id;

    private string $name;

    private string $surname;

    public function __construct(
        UserUuid $id,
        string $name,
        string $surname
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
    }

    public function getId(): UserUuid
    {
        return $this->id;
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
