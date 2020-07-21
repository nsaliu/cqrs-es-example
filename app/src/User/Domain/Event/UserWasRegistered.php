<?php

declare(strict_types=1);

namespace App\User\Domain\Event;

use EventSauce\EventSourcing\Serialization\SerializablePayload;

final class UserWasRegistered implements SerializablePayload
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

    public function toPayload(): array
    {
        return [
            'name' => $this->name,
            'surname' => $this->surname,
        ];
    }

    public static function fromPayload(array $payload): UserWasRegistered
    {
        return new UserWasRegistered(
            (string) $payload['name'],
            (string) $payload['surname']
        );
    }
}
