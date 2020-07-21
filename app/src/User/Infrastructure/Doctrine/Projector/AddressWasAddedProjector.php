<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Projector;

use App\User\Domain\Event\AddressWasAdded;
use EventSauce\EventSourcing\Consumer;
use Jphooiveld\Bundle\EventSauceBundle\ConsumableTrait;

final class AddressWasAddedProjector implements Consumer
{
    use ConsumableTrait;

    public function applyAddressWasAddedProjector(AddressWasAdded $event): void
    {
        dump('in AddressWasAddedProjector projector...');
    }
}
