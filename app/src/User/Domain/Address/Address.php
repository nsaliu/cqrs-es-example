<?php

declare(strict_types=1);

namespace App\User\Domain\Address;

final class Address
{
    private AddressUuid $uuid;

    private string $streetName;

    private int $number;

    public function __construct(
        AddressUuid $uuid,
        string $streetName,
        int $number
    ) {
        $this->uuid = $uuid;
        $this->streetName = $streetName;
        $this->number = $number;
    }

    public function getUuid(): AddressUuid
    {
        return $this->uuid;
    }

    public function getStreetName(): string
    {
        return $this->streetName;
    }

    public function getNumber(): int
    {
        return $this->number;
    }
}
