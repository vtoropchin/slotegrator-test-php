<?php declare(strict_types=1);


namespace Src\User\Dal\Repository;


use Src\Core\Dal\Repository\CoreRepository;
use Src\User\Dal\Entity\User;
use Src\User\Dal\QueryBuilder\UserQueryBuilder;

/**
 * Class UserRepository
 * @package Src\User\Dal\Repository
 */
class UserRepository extends CoreRepository
{
    protected const USER_ALIAS = 'user';

    protected string $queryBuilderClass = UserQueryBuilder::class;

    /**
     * @param int $userId
     *
     * @return User|null
     */
    public function findById(int $userId): ?User
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->find($userId);
    }

    /**
     * @param string $login
     *
     * @return User|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getUserByLogin(string $login): ?User
    {
        /** @var UserQueryBuilder $queryBuilder */
        $queryBuilder = $this->createQueryBuilder(self::USER_ALIAS);
        $queryBuilder->whereLogin($login);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }
}
