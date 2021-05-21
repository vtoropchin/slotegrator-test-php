<?php declare(strict_types=1);

namespace Src\Core\Dal\DbType;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

/**
 * Class AbstractDbType
 */
abstract class AbstractDbType extends Type implements DbTypeInterface
{
    use DbTypeNameTrait;

    /**
     * @param array $fieldDeclaration
     * @param AbstractPlatform $platform
     *
     * @return string|void
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        throw new \RuntimeException('Realize it in the your concrete class');
    }

}
