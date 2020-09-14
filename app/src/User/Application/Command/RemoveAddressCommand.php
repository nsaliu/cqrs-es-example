<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\User\Domain\Address\AddressUuid;
use App\User\Domain\UserId;
use App\User\Domain\UuidInterface;

final class RemoveAddressCommand implements CommandInterface
{
    private UserId $userUuid;

    private AddressUuid $addressUuid;

    public function __construct(
        UserId $userUuid,
        AddressUuid $addressUuid
    ) {
        $this->userUuid = $userUuid;
        $this->addressUuid = $addressUuid;
    }

    public function getAggregateUuid(): UuidInterface
    {
        return $this->userUuid;
    }

    public function getAddressUuid(): AddressUuid
    {
        return $this->addressUuid;
    }
}
