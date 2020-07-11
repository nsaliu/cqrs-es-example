<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Messenger;

use App\User\Application\Command\CommandInterface;
use App\User\Application\Command\RegisterUserCommand;
use App\User\Domain\UserUuid;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Stamp\StampInterface;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

final class CommandSerializer implements CommandSerializerInterface
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function decode(array $encodedEnvelope): Envelope
    {
        $envelop = $this->serializer->decode($encodedEnvelope);

        if ($envelop->getMessage() instanceof CommandInterface) {
            return new Envelope(
                $this->deserializeCommandMessage(
                    $envelop,
                    $encodedEnvelope
                ),
                $this->getStamps($envelop->all())
            );
        }

        return $envelop;
    }

    public function encode(Envelope $envelope): array
    {
        if ($envelope->getMessage() instanceof CommandInterface) {
            /** @var CommandInterface $originalMessage */
            $originalMessage = $envelope->getMessage();

            $encodedMessage = $this->serializer->encode($envelope);

            $messageBody = json_decode($encodedMessage['body'], true);

            $messageBody['uuid'] = $originalMessage->getUuid()->toString();

            $encodedMessage['body'] = json_encode($messageBody);

            return $encodedMessage;
        }

        return $this->serializer->encode($envelope);
    }

    private function deserializeCommandMessage(
        Envelope $envelope,
        array $encodedEnvelope
    ): CommandInterface {
        $body = json_decode($encodedEnvelope['body'], true);
        $message = $envelope->getMessage();

        if ($message instanceof RegisterUserCommand) {
            /** @var RegisterUserCommand $message */


            return new RegisterUserCommand(
                UserUuid::createFromString($body['uuid']),
                $message->getName(),
                $message->getSurname()
            );
        }
    }

    /**
     * @param array<string, array<int, StampInterface>> $stamps
     * @return StampInterface[]
     */
    private function getStamps(array $stamps): array
    {
        $results = [];

        foreach ($stamps as $fccn => $stampArray) {
            foreach ($stampArray as $stamp) {
                $results[] = $stamp;
            }
        }

        return $results;
    }
}
