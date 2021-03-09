<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\User\Domain\UserUuid;

final class UpdateUserNameCommand implements CommandInterface
{
    private UserUuid $uuid;

    private string $name;

    public function __construct(
        UserUuid $uuid,
        string $name
    ) {
        $this->uuid = $uuid;
        $this->name = $name;
    }

    public function getUuid(): UserUuid
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
