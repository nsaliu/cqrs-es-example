<?php

declare(strict_types=1);

namespace App\User\Domain\Event;

use App\User\Domain\Address\AddressUuid;
use App\User\Domain\UserId;
use EventSauce\EventSourcing\Serialization\SerializablePayload;

final class AddressChanged implements SerializablePayload
{
    private UserId $userId;

    private AddressUuid $oldAddressUuid;

    private string $oldStreetName;

    private int $oldStreetNumber;

    private AddressUuid $newAddressUuid;

    private string $newStreetName;

    private int $newStreetNumber;

    public function __construct(
        UserId $userId,
        AddressUuid $oldAddressUuid,
        string $oldStreetName,
        int $oldStreetNumber,
        AddressUuid $newAddressUuid,
        string $newStreetNAme,
        int $newStreetNumber
    ) {
        $this->userId = $userId;
        $this->oldAddressUuid = $oldAddressUuid;
        $this->oldStreetName = $oldStreetName;
        $this->oldStreetNumber = $oldStreetNumber;
        $this->newAddressUuid = $newAddressUuid;
        $this->newStreetName = $newStreetNAme;
        $this->newStreetNumber = $newStreetNumber;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getOldAddressUuid(): AddressUuid
    {
        return $this->oldAddressUuid;
    }

    public function getOldStreetName(): string
    {
        return $this->oldStreetName;
    }

    public function getOldStreetNumber(): int
    {
        return $this->oldStreetNumber;
    }

    public function getNewAddressUuid(): AddressUuid
    {
        return $this->newAddressUuid;
    }

    public function getNewStreetName(): string
    {
        return $this->newStreetName;
    }

    public function getNewStreetNumber(): int
    {
        return $this->newStreetNumber;
    }

    /**
     * @return array<string, mixed>
     */
    public function toPayload(): array
    {
        return [
            'user_uuid' => $this->userId->toString(),
            'old_address_uuid' => $this->oldAddressUuid->toString(),
            'old_street_name' => $this->oldStreetName,
            'old_street_number' => $this->oldStreetNumber,
            'new_address_uuid' => $this->newAddressUuid->toString(),
            'new_street_name' => $this->newStreetName,
            'new_street_number' => $this->newStreetNumber,
        ];
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromPayload(array $payload): SerializablePayload
    {
        return new AddressChanged(
            UserId::fromString($payload['user_uuid']),
            AddressUuid::fromString($payload['old_address_uuid']),
            (string) $payload['old_street_name'],
            (int) $payload['old_street_number'],
            AddressUuid::fromString($payload['new_address_uuid']),
            (string) $payload['new_street_name'],
            (int) $payload['new_street_number']
        );
    }
}
