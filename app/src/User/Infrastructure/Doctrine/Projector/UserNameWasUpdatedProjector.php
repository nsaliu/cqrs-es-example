<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Projector;

use App\User\Domain\Event\UserNameWasUpdated;
use EventSauce\EventSourcing\Consumer;
use Jphooiveld\Bundle\EventSauceBundle\ConsumableTrait;

final class UserNameWasUpdatedProjector implements Consumer
{
    use ConsumableTrait;

    public function applyUserNameWasUpdated(UserNameWasUpdated $event): void
    {
        dump('in UserNameWasUpdated projector...');
    }
}
