<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine\Type;

use App\Shared\Infrastructure\Uuid\GenericUuid;
use App\Shared\Infrastructure\Uuid\UuidInterface;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use Throwable;

final class GenericUuidType extends Type
{
    private const TYPE_NAME = 'generic_uuid';

    public function convertToDatabaseValue(
        $value,
        AbstractPlatform $platform
    ): string {
        if ($value instanceof UuidInterface) {
            return $value->toString();
        }

        try {
            return GenericUuid::fromString($value)->toString();
        } catch (Throwable $exception) {
            throw ConversionException::conversionFailedInvalidType($value, $this->getName(), [GenericUuid::class]);
        }
    }

    public function convertToPHPValue(
        $value,
        AbstractPlatform $platform
    ): UuidInterface {
        if ($value instanceof UuidInterface) {
            return $value;
        }

        try {
            return GenericUuid::fromString($value);
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
