<?php declare(strict_types=1);


namespace Src\Prize\Services;


use Doctrine\ORM\EntityManagerInterface;
use Src\Prize\Dal\Entity\Prize;
use Src\Prize\Dal\Repository\PrizeRepository;
use Src\Prize\Services\Strategies\PrizeStrategyExecutor;
use Src\User\Exceptions\UnauthorizedHttpException;
use Src\User\Exceptions\UserDoesNotExist;
use Src\User\Services\UserService;

/**
 * Class PrizeService
 * @package Src\Prize\Services
 */
class PrizeService
{
    protected UserService $userService;
    protected EntityManagerInterface $entityManager;
    protected PrizeRepository $prizeRepository;
    protected PrizeStrategyExecutor $prizeStrategyExecutor;

    public function __construct(
        UserService $userService,
        EntityManagerInterface $entityManager,
        PrizeRepository $prizeRepository,
        PrizeStrategyExecutor $prizeStrategyExecutor
    ) {
        $this->userService = $userService;
        $this->entityManager = $entityManager;
        $this->prizeRepository = $prizeRepository;
        $this->prizeStrategyExecutor = $prizeStrategyExecutor;
    }

    /**
     * @param string   $type
     * @param string   $name
     * @param int|null $availableNumber
     *
     * @return Prize
     */
    public function addPrize(string $type, string $name, ?int $availableNumber = null): Prize
    {
        $prize = new Prize($type, $name, $availableNumber);
        $this->entityManager->persist($prize);
        $this->entityManager->flush();

        return $prize;
    }

    /**
     * @param int|null $userId
     *
     * @return Prize
     * @throws UnauthorizedHttpException
     * @throws UserDoesNotExist
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function addRandomPrizeToCurrentUser(?int $userId = null): Prize
    {
        if ($userId === null) {
            $user = $this->userService->getCurrentUser();
            if ($user === null) {
                throw new UnauthorizedHttpException();
            }
        } else {
            $user = $this->userService->getUserById($userId);
            if ($user === null) {
                throw new UserDoesNotExist();
            }
        }

        $randomPrize = $this->prizeRepository->getRandomAvailablePrize();

        if ($randomPrize !== null) {
            $result = $this->prizeStrategyExecutor->runAllStrategies($user, $randomPrize);
            if ($result === false) {
                throw new \RuntimeException($this->prizeStrategyExecutor->getErrors()[0], 200);
            }
        } else {
            throw new \RuntimeException('Prizes run out', 410);
        }

        return $randomPrize;
    }
}
