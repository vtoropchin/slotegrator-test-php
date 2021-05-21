<?php declare(strict_types=1);

namespace Src\Core\Dal\DbType;

use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Class AbstractEnum
 * @package Src\Core\Dal\DbType
 */
class AbstractEnum extends AbstractDbType implements EnumDbTypeInterface
{
    /**
     * @see https://dev.mysql.com/doc/refman/5.6/en/enum.html#enum-indexes Empty strings in ENUMs
     */
    protected const DEFAULT_VALUE = null;

    /** @var int[]|string[] */
    protected const VALUES = [];

    /**
     * @return int[]|string[]
     */
    public static function getAllValues() : array
    {
        return static::VALUES;
    }

    /**
     * @return int|string|null
     */
    public static function getDefaultValue()
    {
        return static::DEFAULT_VALUE;
    }

    /**
     * @param array            $fieldDeclaration
     * @param AbstractPlatform $platform
     *
     * @return string
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) : string
    {
        $values = "'" . implode("', '", static::VALUES) . "'";

        return sprintf(
            'ENUM(%s) COMMENT \'(DC2Type:%s)\'',
            $values,
            $this->getName()
        );
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     *
     * @return mixed
     * @noinspection PhpMissingParentCallCommonInspection
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!\in_array($value, static::VALUES, true)) {
            throw new \InvalidArgumentException(sprintf('Invalid value: `%s`', $value));
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     * @noinspection PhpMissingParentCallCommonInspection
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        /**
         * in case of empty string
         * @see https://dev.mysql.com/doc/refman/5.6/en/enum.html#enum-indexes Empty strings in ENUMs
         */
        if ($value === '') {
            return static::DEFAULT_VALUE;
        }

        // in case of LEFT JOIN without 'left join'ed entity
        if ($value === null) {
            return null;
        }

        foreach (static::VALUES as $enumValue) {
            /** @noinspection TypeUnsafeComparisonInspection For enums with numeric values */
            if ($enumValue == $value) {
                return $enumValue;
            }
        }

        throw new \InvalidArgumentException(sprintf('Unexpected value: `%s`', $value));
   }

    /**
     * @param AbstractPlatform $platform
     *
     * @return array
     * @noinspection PhpMissingParentCallCommonInspection
     */
    public function getMappedDatabaseTypes(AbstractPlatform $platform) : array
    {
        return [
            'enum',
        ];
    }

    /**
     * @param string|int $value
     * @return bool
     */
    public static function hasValue($value) : bool
    {
        return \in_array($value, static::VALUES, true);
    }

}
