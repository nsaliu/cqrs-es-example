<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\User\Domain\UserId;
use App\User\Domain\UuidInterface;

final class AddAddressCommand implements CommandInterface
{
    private UserId $userUuid;

    private string $streetName;

    private int $streetNumber;

    public function __construct(
        UserId $userUuid,
        string $streetName,
        int $streetNumber
    ) {
        $this->userUuid = $userUuid;
        $this->streetName = $streetName;
        $this->streetNumber = $streetNumber;
    }

    public function getAggregateUuid(): UuidInterface
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
