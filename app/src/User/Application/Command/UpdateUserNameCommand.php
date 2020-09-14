<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\User\Domain\UserId;

final class UpdateUserNameCommand implements CommandInterface
{
    private UserId $uuid;

    private string $name;

    public function __construct(
        UserId $uuid,
        string $name
    ) {
        $this->uuid = $uuid;
        $this->name = $name;
    }

    public function getAggregateUuid(): UserId
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
