<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\User\Domain\UuidInterface;

interface CommandInterface
{
    public function getAggregateUuid(): UuidInterface;
}
