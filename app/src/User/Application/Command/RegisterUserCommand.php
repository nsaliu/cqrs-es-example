<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\User\Domain\UserId;

final class RegisterUserCommand implements CommandInterface
{
    private UserId $uuid;

    private string $name;

    private string $surname;

    public function __construct(
        UserId $uuid,
        string $name,
        string $surname
    ) {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->surname = $surname;
    }

    public function getAggregateUuid(): UserId
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
