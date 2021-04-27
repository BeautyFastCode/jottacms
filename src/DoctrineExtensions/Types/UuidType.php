<?php declare(strict_types=1);

namespace App\DoctrineExtensions\Types;

use InvalidArgumentException;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\GuidType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Symfony\Component\Uid\Uuid;

/**
 * Field type mapping for the Doctrine Database Abstraction Layer (DBAL).
 *
 * UUID fields will be stored as a string in the database and converted back to
 * the Uuid value object when querying.
 *
 * @see: https://raw.githubusercontent.com/ramsey/uuid-doctrine/master/src/UuidType.php
 */
final class UuidType extends GuidType
{
    /**
     * @var string
     */
    const NAME = 'uuid';

    /**
     * {@inheritdoc}
     *
     * @param string|Uuid|null $value
     * @param AbstractPlatform $platform
     *
     * @return Uuid|null
     *
     * @throws ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?Uuid
    {
        if ($value === null || $value === '') {
            return null;
        }

        if ($value instanceof Uuid) {
            return $value;
        }

        try {
            $uuid = Uuid::fromString($value);
        } catch (InvalidArgumentException $e) {
            throw ConversionException::conversionFailed($value, UuidType::NAME);
        }

        return $uuid;
    }

    /**
     * {@inheritdoc}
     *
     * @param Uuid|string|null $value
     * @param AbstractPlatform $platform
     *
     * @return string|null
     *
     * @throws ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (
            $value instanceof Uuid
            || (
                (is_string($value)
                    || method_exists($value, '__toString'))
                && Uuid::isValid((string) $value)
            )
        ) {
            return (string) $value;
        }

        throw ConversionException::conversionFailed($value, UuidType::NAME);
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getName(): string
    {
        return UuidType::NAME;
    }
}
