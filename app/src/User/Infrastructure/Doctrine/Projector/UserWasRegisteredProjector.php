<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Projector;

use App\User\Domain\Event\UserWasRegistered;
use EventSauce\EventSourcing\Consumer;
use Jphooiveld\Bundle\EventSauceBundle\ConsumableTrait;

final class UserWasRegisteredProjector implements Consumer
{
    use ConsumableTrait;

    public function applyUserWasRegistered(UserWasRegistered $event): void
    {
        dump('in UserWasRegisteredProjector projector...');
    }
}
