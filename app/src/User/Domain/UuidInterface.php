<?php

declare(strict_types=1);

namespace App\User\Domain;

interface UuidInterface
{
    public function toString(): string;
}
