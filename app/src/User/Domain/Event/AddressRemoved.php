<?php

declare(strict_types=1);

namespace App\User\Domain\Event;

use App\User\Domain\Address\AddressUuid;
use App\User\Domain\UserUuid;
use EventSauce\EventSourcing\Serialization\SerializablePayload;

final class AddressRemoved implements SerializablePayload
{
    private UserUuid $userUuid;

    private AddressUuid $addressUuid;

    public function __construct(
        UserUuid $userUuid,
        AddressUuid $addressUuid
    ) {
        $this->userUuid = $userUuid;
        $this->addressUuid = $addressUuid;
    }

    public function getUserUuid(): UserUuid
    {
        return $this->userUuid;
    }

    public function getAddressUuid(): AddressUuid
    {
        return $this->addressUuid;
    }

    /**
     * @return array<string, mixed>
     */
    public function toPayload(): array
    {
        return [
            'user_uuid' => $this->userUuid->toString(),
            'address_uuid' => $this->addressUuid->toString(),
        ];
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromPayload(array $payload): SerializablePayload
    {
        return new AddressRemoved(
            UserUuid::fromString((string) $payload['user_uuid']),
            AddressUuid::fromString((string) $payload['address_uuid']),
        );
    }
}
