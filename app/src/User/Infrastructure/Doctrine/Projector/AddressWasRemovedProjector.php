<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Projector;

use App\User\Domain\Event\AddressWasRemoved;
use EventSauce\EventSourcing\Consumer;
use Jphooiveld\Bundle\EventSauceBundle\ConsumableTrait;

final class AddressWasRemovedProjector implements Consumer
{
    use ConsumableTrait;

    public function applyAddressWasRemoved(AddressWasRemoved $event)
    {
        dump('in AddressWasRemoved projector...');
    }
}
