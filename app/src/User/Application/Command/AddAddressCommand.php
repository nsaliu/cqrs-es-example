<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\User\Domain\UserId;

final class AddAddressCommand implements CommandInterface
{
    private UserId $userUuid;

    private string $streetName;

    private int $streetNumber;

    public function __construct(
        UserId $uuid,
        string $streetName,
        int $streetNumber
    ) {
        $this->userUuid = $uuid;
        $this->streetName = $streetName;
        $this->streetNumber = $streetNumber;
    }

    public function getAggregateUuid(): UserId
    {
        return $this->userUuid;
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
