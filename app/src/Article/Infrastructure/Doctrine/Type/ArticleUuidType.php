<?php

declare(strict_types=1);

namespace App\Article\Infrastructure\Doctrine\Type;

use App\Article\Domain\ArticleUuid;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use Throwable;

final class ArticleUuidType extends Type
{
    private const TYPE_NAME = 'article_uuid';

    public function convertToDatabaseValue(
        $value,
        AbstractPlatform $platform
    ): string {
        if ($value instanceof ArticleUuid) {
            return $value->toString();
        }

        try {
            return ArticleUuid::fromString($value)->toString();
        } catch (Throwable $exception) {
            throw ConversionException::conversionFailedInvalidType($value, $this->getName(), [ArticleUuid::class]);
        }
    }

    public function convertToPHPValue(
        $value,
        AbstractPlatform $platform
    ): ArticleUuid {
        if ($value instanceof ArticleUuid) {
            return $value;
        }

        try {
            return ArticleUuid::fromString($value);
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
