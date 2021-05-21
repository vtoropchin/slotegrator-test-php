<?php declare(strict_types=1);


namespace Src\Prize\Dal\Repository;


use Src\Core\Dal\Repository\CoreRepository;
use Src\Prize\Dal\Entity\Prize;
use Src\Prize\Dal\QueryBuilder\PrizeQueryBuilder;

/**
 * Class UserRepository
 * @package Src\User\Dal\Repository
 */
class PrizeRepository extends CoreRepository
{
    protected const PRIZE_ALIAS = 'prize';

    protected string $queryBuilderClass = PrizeQueryBuilder::class;

    /**
     * @return Prize|null
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getRandomAvailablePrize(): ?Prize
    {
        /** @var PrizeQueryBuilder $queryBuilder */
        $queryBuilder = $this->createQueryBuilder(self::PRIZE_ALIAS);
        $rows = (int)$queryBuilder->select('COUNT(prize)')
            ->whereAvailable()
            ->getQuery()
            ->getSingleScalarResult();

        if ($rows === 0) {
            return null;
        }

        $offset = max(0, random_int(0, $rows - 1));

        $queryBuilder = $this->createQueryBuilder(self::PRIZE_ALIAS);
        $queryBuilder->whereAvailable();
        $queryBuilder->setFirstResult($offset);
        $queryBuilder->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * @param int $prizeId
     *
     * @return Prize|null
     */
    public function getPrizeById(int $prizeId): ?Prize
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->find($prizeId);
    }
}
