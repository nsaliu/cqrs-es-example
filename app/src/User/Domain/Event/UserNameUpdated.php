<?php

declare(strict_types=1);

namespace App\User\Domain\Event;

use App\User\Domain\UserUuid;
use EventSauce\EventSourcing\Serialization\SerializablePayload;

final class UserNameUpdated implements SerializablePayload
{
    private UserUuid $userUuid;

    private string $name;

    public function __construct(
        UserUuid $userUuid,
        string $name
    ) {
        $this->userUuid = $userUuid;
        $this->name = $name;
    }

    public function getUserUuid(): UserUuid
    {
        return $this->userUuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array<string, mixed>
     */
    public function toPayload(): array
    {
        return [
            'user_uuid' => $this->userUuid->toString(),
            'name' => $this->name,
        ];
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromPayload(array $payload): UserNameUpdated
    {
        return new UserNameUpdated(
            UserUuid::fromString((string) $payload['user_uuid']),
            (string) $payload['name']
        );
    }
}
