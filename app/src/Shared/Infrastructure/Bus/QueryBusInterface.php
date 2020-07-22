<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus;

interface QueryBusInterface
{
    public function dispatch(object $command): object;
}
