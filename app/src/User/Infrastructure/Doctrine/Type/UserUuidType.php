<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Type;

use App\User\Domain\UserId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use Throwable;

final class UserUuidType extends Type
{
    private const TYPE_NAME = 'user_uuid';

    public function convertToDatabaseValue(
        $value,
        AbstractPlatform $platform
    ): string {
        if ($value instanceof UserId) {
            return $value->toString();
        }

        try {
            return UserId::fromString($value)->toString();
        } catch (Throwable $exception) {
            throw ConversionException::conversionFailedInvalidType($value, $this->getName(), [UserId::class]);
        }
    }

    public function convertToPHPValue(
        $value,
        AbstractPlatform $platform
    ): UserId {
        if ($value instanceof UserId) {
            return $value;
        }

        try {
            return UserId::fromString($value);
        } catch (Throwable $exception) {
            throw ConversionException::conversionFailed($value, $this->getName());
        }
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    public function getName(): string
    {
        return self::TYPE_NAME;
    }
}
