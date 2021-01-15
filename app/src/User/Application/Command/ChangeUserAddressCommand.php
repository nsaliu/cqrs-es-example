<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\User\Domain\Address\AddressUuid;
use App\User\Domain\UserId;

final class ChangeUserAddressCommand implements CommandInterface
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
        string $newStreetName,
        int $newStreetNumber
    ) {
        $this->userId = $userId;
        $this->oldAddressUuid = $oldAddressUuid;
        $this->oldStreetName = $oldStreetName;
        $this->oldStreetNumber = $oldStreetNumber;
        $this->newAddressUuid = $newAddressUuid;
        $this->newStreetName = $newStreetName;
        $this->newStreetNumber = $newStreetNumber;
    }

    public function getAggregateUuid(): UserId
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
}
