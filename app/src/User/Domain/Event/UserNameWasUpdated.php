<?php

declare(strict_types=1);

namespace App\User\Domain\Event;

use EventSauce\EventSourcing\Serialization\SerializablePayload;

final class UserNameWasUpdated implements SerializablePayload
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

    public function toPayload(): array
    {
        return [
            'name' => $this->surname,
        ];
    }

    public static function fromPayload(array $payload): UserNameWasUpdated
    {
        return new UserNameWasUpdated(
            (string) $payload['name']
        );
    }
}
