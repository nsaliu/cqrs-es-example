<?php

declare(strict_types=1);

namespace App\Article\Infrastructure\Messenger;

use App\Shared\Infrastructure\Bus\QueryBusInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerQueryBus implements QueryBusInterface
{
    use HandleTrait;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function dispatch(object $command): object
    {
        return $this->handle($command);
    }
}
