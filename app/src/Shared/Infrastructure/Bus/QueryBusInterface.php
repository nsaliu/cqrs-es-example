<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus;

interface QueryBusInterface
{
    /**
     * @return mixed
     */
    public function dispatch(object $command): object;
}
