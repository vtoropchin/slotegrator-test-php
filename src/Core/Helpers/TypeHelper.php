<?php declare(strict_types=1);


namespace Src\Core\Helpers;


/**
 * Class TypeHelper
 * @package App\Core\Helpers
 */
class TypeHelper
{
    /**
     * @param $value
     *
     * @return float|int|string
     */
    public static function convertValueToProbableType($value)
    {
        if (is_array($value)) {
            array_walk_recursive($value, static function (&$value) {
                if (is_string($value)) {
                    $value = self::convertStrToProbableType($value);
                }

                return $value;
            });
        } elseif (is_string($value)) {
            $value = self::convertStrToProbableType($value);
        }

        return $value;
    }

    /**
     * @param string $value
     *
     * @return bool|int|float|string|null
     * @noinspection CallableParameterUseCaseInTypeContextInspection
     */
    protected static function convertStrToProbableType(string $value)
    {
        if (is_string($value)) {
            $value = (string)(int)$value === $value ? (int)$value : $value;
        }

        if (is_string($value)) {
            /**
             * @noinspection TypeUnsafeComparisonInspection
             * The not strict comparison is necessary for correct converting a str as float value to real float value
             */
            $value = (string)(double)$value == $value ? (double)$value : $value;
        }

        if (is_string($value) && strcasecmp($value, 'true') === 0) {
            $value = true;
        }

        if (is_string($value) && strcasecmp($value, 'false') === 0) {
            $value = false;
        }

        if (is_string($value) && strcasecmp($value, 'null') === 0) {
            $value = null;
        }

        return $value;
    }

    /**
     * @param $value
     * @param $defaultValue
     *
     * @return string
     */
    public static function convertToString($value, string $defaultValue = ''): string
    {
        $convertedValue = (string)$value;

        if (!self::isCorrectlyConverted($value, $convertedValue)) {
            $convertedValue = $defaultValue;
        }

        return $convertedValue;
    }

    /**
     * @param $originalValue
     * @param $convertedValue
     *
     * @return bool
     */
    protected static function isCorrectlyConverted($originalValue, $convertedValue): bool
    {
        $result = true;

        $typeOriginalValue = gettype($originalValue);

        if ($typeOriginalValue === 'boolean') {
            $restoredValue = (boolean)$convertedValue;
        } elseif ($typeOriginalValue === 'integer') {
            $restoredValue = (int)$convertedValue;
        } elseif ($typeOriginalValue === 'double') {
            $restoredValue = (double)$convertedValue;
        } elseif ($typeOriginalValue === 'string') {
            $restoredValue = (string)$convertedValue;
        } elseif ($typeOriginalValue === 'NULL' && $originalValue === null) {
            $restoredValue = null;
        }

        if (!isset($restoredValue) || $originalValue !== $restoredValue) {
            $result = false;
        }

        return $result;
    }
}
