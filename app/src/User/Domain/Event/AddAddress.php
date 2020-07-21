<?php

declare(strict_types=1);

namespace App\User\Domain\Event;

use App\User\Domain\Address\AddressUuid;
use App\User\Domain\UserUuid;

final class AddAddress
{
    private UserUuid $userUuid;

    private AddressUuid $addressUuid;

    private string $streetName;

    private int $streetNumber;

    public function __construct(
        UserUuid $userUuid,
        AddressUuid $addressUuid,
        string $streetName,
        int $streetNumber
    ) {
        $this->userUuid = $userUuid;
        $this->streetName = $streetName;
        $this->streetNumber = $streetNumber;
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

    public function getStreetName(): string
    {
        return $this->streetName;
    }

    public function getStreetNumber(): int
    {
        return $this->streetNumber;
    }
}
