<?php

declare(strict_types=1);

namespace App\User\Domain\Event;

use App\User\Domain\UserUuid;
use EventSauce\EventSourcing\Serialization\SerializablePayload;

final class UserWasRegistered implements SerializablePayload
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

    /**
     * @return array<string, mixed>
     */
    public function toPayload(): array
    {
        return [
            'user_uuid' => $this->userUuid->toString(),
            'name' => $this->name,
            'surname' => $this->surname,
        ];
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromPayload(array $payload): UserWasRegistered
    {
        return new UserWasRegistered(
            UserUuid::fromString((string) $payload['user_uuid']),
            (string) $payload['name'],
            (string) $payload['surname']
        );
    }
}
