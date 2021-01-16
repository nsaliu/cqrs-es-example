<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Shared\Infrastructure\Uuid\UuidInterface;

interface CommandInterface
{
    public function getAggregateUuid(): UuidInterface;
}
