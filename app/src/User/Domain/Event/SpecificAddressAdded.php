<?php

declare(strict_types=1);

namespace App\User\Domain\Event;

use App\User\Domain\Address\AddressUuid;
use App\User\Domain\UserUuid;
use EventSauce\EventSourcing\Serialization\SerializablePayload;

final class SpecificAddressAdded implements SerializablePayload
{
    private UserUuid $userUuid;

    private AddressUuid $addressUuid;

    private string $streetName;

    private int $streetNumber;

    private string $userName;

    private string $userSurname;

    public function __construct(
        UserUuid $userUuid,
        AddressUuid $addressUuid,
        string $streetName,
        int $streetNumber,
        string $userName,
        string $userSurname
    ) {
        $this->streetName = $streetName;
        $this->streetNumber = $streetNumber;
        $this->addressUuid = $addressUuid;
        $this->userUuid = $userUuid;
        $this->userName = $userName;
        $this->userSurname = $userSurname;
    }

    public function getUserUuid(): UserUuid
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

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function getUserSurname(): string
    {
        return $this->userSurname;
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
            'user_name' => $this->userName,
            'user_surname' => $this->userSurname,
        ];
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromPayload(array $payload): SerializablePayload
    {
        return new SpecificAddressAdded(
            UserUuid::fromString((string) $payload['user_uuid']),
            AddressUuid::fromString((string) $payload['address_uuid']),
            (string) $payload['street_name'],
            (int) $payload['street_number'],
            (string) $payload['user_name'],
            (string) $payload['user_surname'],
        );
    }
}
