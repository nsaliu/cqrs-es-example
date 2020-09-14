<?php

declare(strict_types=1);

namespace App\User\Domain\Event;

use App\User\Domain\UserId;
use EventSauce\EventSourcing\Serialization\SerializablePayload;

final class UserRegistered implements SerializablePayload
{
    private UserId $userUuid;

    private string $name;

    private string $surname;

    public function __construct(
        UserId $userUuid,
        string $name,
        string $surname
    ) {
        $this->userUuid = $userUuid;
        $this->name = $name;
        $this->surname = $surname;
    }

    public function getUserUuid(): UserId
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
    public static function fromPayload(array $payload): UserRegistered
    {
        return new UserRegistered(
            UserId::fromString((string) $payload['user_uuid']),
            (string) $payload['name'],
            (string) $payload['surname']
        );
    }
}
