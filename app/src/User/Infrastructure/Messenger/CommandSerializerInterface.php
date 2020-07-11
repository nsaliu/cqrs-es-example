<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Messenger;

use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

interface CommandSerializerInterface extends SerializerInterface
{

}
