<?php declare(strict_types=1);


namespace Src\Prize\Dal\QueryBuilder;


use Src\Core\Dal\QueryBuilder\CoreQueryBuilder;

/**
 * Class PrizeQueryBuilder
 * @package Src\User\Dal\QueryBuilder
 */
class PrizeQueryBuilder extends CoreQueryBuilder
{
    /**
     * @return PrizeQueryBuilder
     */
    public function whereAvailable(): PrizeQueryBuilder
    {
        $rootAlias = $this->getRootAliases()[0];

        return $this->andWhere("$rootAlias.availableNumber IS NULL OR $rootAlias.availableNumber > 0");
    }
}
