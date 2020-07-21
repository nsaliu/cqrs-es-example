<?php

declare(strict_types=1);

namespace App\User\Domain\Event;

final class RegisterNewUser
{
    private string $name;

    private string $surname;

    public function __construct(
        string $name,
        string $surname
    ) {
        $this->name = $name;
        $this->surname = $surname;
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
