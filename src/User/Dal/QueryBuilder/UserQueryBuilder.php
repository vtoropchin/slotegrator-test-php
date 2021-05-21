<?php declare(strict_types=1);


namespace Src\User\Dal\QueryBuilder;


use Src\Core\Dal\QueryBuilder\CoreQueryBuilder;

/**
 * Class UserQueryBuilder
 * @package Src\User\Dal\QueryBuilder
 */
class UserQueryBuilder extends CoreQueryBuilder
{
    /**
     * @param string $login
     *
     * @return $this
     */
    public function whereLogin(string $login): UserQueryBuilder
    {
        $rootAlias = $this->getRootAliases()[0];

        $this->andWhere("$rootAlias.login = :login")
            ->setParameter('login', $login);

        return $this;
    }
}
