<?php declare(strict_types=1);


namespace Src\Prize\Services\Strategies;


use Doctrine\ORM\EntityManagerInterface;
use Src\Prize\Dal\Entity\Prize;
use Src\Prize\Dal\Entity\UsersPrizes;
use Src\Prize\Dal\Enum\PrizeTypeEnum;
use Src\Prize\Dal\Repository\PrizeRepository;
use Src\Prize\Services\Strategies\Dto\StrategyOutputDto;
use Src\User\Dal\Entity\User;

/**
 * Class ReservePrizeStrategy
 * @package Src\Prize\Services\Strategies
 */
class ReservePrizeStrategy implements PrizeStrategyInterface
{
    protected PrizeRepository $prizeRepository;
    protected EntityManagerInterface $entityManager;

    /**
     * ReservePrizeStrategy constructor.
     *
     * @param PrizeRepository        $prizeRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(PrizeRepository $prizeRepository, EntityManagerInterface $entityManager)
    {
        $this->prizeRepository = $prizeRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param User  $user
     * @param Prize $prize
     *
     * @return StrategyOutputDto
     * @throws \Exception
     */
    public function runStrategy(User $user, Prize $prize): StrategyOutputDto
    {
        $result = new StrategyOutputDto();

        $this->entityManager->refresh($prize);
        $availableNumber = $prize->getAvailableNumber();
        if ($availableNumber !== null) {
            if ($availableNumber === 0) {
                $result->isSuccess = false;
                $result->error = "Prizes {$prize->getName()} run out. Try again to get another prize.";
            } else {
                $prize->setAvailableNumber($prize->getAvailableNumber() - 1);
                $this->entityManager->persist($prize);
                $this->entityManager->flush();
            }
        }

        if ($result->isSuccess) {
            $usersPrizes = new UsersPrizes($user->getId(), $prize->getId(), $this->generatePrizeNumber($prize->getType(), $availableNumber));
            $this->entityManager->persist($usersPrizes);
            $this->entityManager->flush();
        }

        return $result;
    }

    /**
     * @param string   $prizeType
     * @param int|null $maxAvailable
     *
     * @return int
     * @throws \Exception
     */
    protected function generatePrizeNumber(string $prizeType, ?int $maxAvailable): int
    {
        if ($prizeType === PrizeTypeEnum::THING) {
            return 1;
        }

        if ($maxAvailable !== null) {
            return random_int(1, $maxAvailable);
        }

        return random_int(1, 1000); // todo There is need use a config value
    }
}
