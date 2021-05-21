<?php declare(strict_types=1);


namespace Src\Core\Dal\Repository;


use Doctrine\ORM\EntityRepository;
use Src\Core\Dal\QueryBuilder\CoreQueryBuilder;

/**
 * Class CoreRepository
 * @package Src\Core\Dal\Repository
 */
class CoreRepository extends EntityRepository
{
    /** @var string  The name of a query builder class */
    protected string $queryBuilderClass;

    /** @var int */
    protected const IDS_IN_QUERY_LIMIT = 1000;

    protected const DATE_FORMAT = 'Y-m-d';
    protected const DATETIME_FORMAT = 'Y-m-d H:i:s';

    /**
     * @param string $alias
     * @param null   $indexBy
     *
     * @return CoreQueryBuilder
     * @noinspection PhpMissingParentCallCommonInspection
     */
    public function createQueryBuilder($alias, $indexBy = null): CoreQueryBuilder
    {
        $queryBuilderClass = $this->queryBuilderClass ?? CoreQueryBuilder::class;

        $queryBuilder = new $queryBuilderClass($this->getEntityManager());
        if (!$queryBuilder instanceof CoreQueryBuilder) {
            throw new \LogicException(sprintf(
                'Query builder class `%s` specified in the `%s` does not extend `%s`',
                $queryBuilderClass,
                static::class,
                CoreQueryBuilder::class
            ));
        }

        $queryBuilder->select($alias)
            ->from($this->_entityName, $alias, $indexBy);

        return $queryBuilder;
    }
}
