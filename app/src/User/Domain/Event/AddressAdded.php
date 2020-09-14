<?php

declare(strict_types=1);

namespace App\User\Domain\Event;

use App\User\Domain\Address\AddressUuid;
use App\User\Domain\UserId;
use EventSauce\EventSourcing\Serialization\SerializablePayload;

final class AddressAdded implements SerializablePayload
{
    private UserId $userUuid;

    private AddressUuid $addressUuid;

    private string $streetName;

    private int $streetNumber;

    public function __construct(
        UserId $userUuid,
        AddressUuid $addressUuid,
        string $streetName,
        int $streetNumber
    ) {
        $this->streetName = $streetName;
        $this->streetNumber = $streetNumber;
        $this->addressUuid = $addressUuid;
        $this->userUuid = $userUuid;
    }

    public function getUserUuid(): UserId
    {
        return $this->userUuid;
    }

    public function getAddressUuid(): AddressUuid
    {
        return $this->addressUuid;
    }

    public function getStreetName(): string
    {
        return $this->streetName;
    }

    public function getStreetNumber(): int
    {
        return $this->streetNumber;
    }

    /**
     * @return array<string, mixed>
     */
    public function toPayload(): array
    {
        return [
            'user_uuid' => $this->userUuid->toString(),
            'address_uuid' => $this->addressUuid->toString(),
            'street_name' => $this->streetName,
            'street_number' => $this->streetNumber,
        ];
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromPayload(array $payload): SerializablePayload
    {
        return new AddressAdded(
            UserId::fromString((string) $payload['user_uuid']),
            AddressUuid::fromString((string) $payload['address_uuid']),
            (string) $payload['street_name'],
            (int) $payload['street_number']
        );
    }
}
