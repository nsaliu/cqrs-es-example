<?php

declare(strict_types=1);

namespace App\User\Domain\Event;

use App\User\Domain\Address\AddressUuid;
use EventSauce\EventSourcing\Serialization\SerializablePayload;

final class AddressWasAdded implements SerializablePayload
{
    private AddressUuid $addressUuid;

    private string $streetName;

    private int $streetNumber;

    public function __construct(
        AddressUuid $addressUuid,
        string $streetName,
        int $streetNumber
    ) {
        $this->streetName = $streetName;
        $this->streetNumber = $streetNumber;
        $this->addressUuid = $addressUuid;
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

    public function toPayload(): array
    {
        return [
            'uuid' => $this->addressUuid->toString(),
            'street_name' => $this->streetName,
            'street_number' => $this->streetNumber,
        ];
    }

    public static function fromPayload(array $payload): SerializablePayload
    {
        return new AddressWasAdded(
            AddressUuid::fromString((string) $payload['uuid']),
            (string) $payload['street_name'],
            (int) $payload['street_number']
        );
    }
}
