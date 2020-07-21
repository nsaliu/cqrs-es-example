<?php

declare(strict_types=1);

namespace App\User\Domain\Event;

use App\User\Domain\UserUuid;
use EventSauce\EventSourcing\Serialization\SerializablePayload;

final class UserNameWasUpdated implements SerializablePayload
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

    public function toPayload(): array
    {
        return [
            'user_uuid' => $this->userUuid->toString(),
            'name' => $this->name,
        ];
    }

    public static function fromPayload(array $payload): UserNameWasUpdated
    {
        return new UserNameWasUpdated(
            UserUuid::fromString((string) $payload['user_uuid']),
            (string) $payload['name']
        );
    }
}
