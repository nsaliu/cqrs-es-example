<?php

declare(strict_types=1);

namespace App\User\Domain\Event;

use EventSauce\EventSourcing\Serialization\SerializablePayload;

final class UpdateUserName
{
    private string $surname;

    public function __construct(string $surname)
    {
        $this->surname = $surname;
    }

    public function getName(): string
    {
        return $this->surname;
    }
}
