<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Messenger;

use App\Shared\Infrastructure\Bus\CommandBusInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerCommandBus implements CommandBusInterface
{
    use HandleTrait;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function dispatch(object $command): void
    {
        $this->messageBus->dispatch($command);
    }
}
