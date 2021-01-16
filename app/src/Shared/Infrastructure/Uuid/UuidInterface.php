<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Uuid;

use EventSauce\EventSourcing\AggregateRootId;

interface UuidInterface extends AggregateRootId
{
    public function equalsTo(UuidInterface $uuid): bool;

    public function toString(): string;
}
