<?php declare(strict_types=1);


namespace Src\Prize\Services\Strategies;


use Src\Prize\Dal\Entity\Prize;
use Src\Prize\Services\Strategies\Dto\StrategyOutputDto;
use Src\User\Dal\Entity\User;

/**
 * Interface PrizeStrategyInterface
 * @package Src\Prize\Services\Strategies
 */
interface PrizeStrategyInterface
{
    /**
     * @param User  $user
     * @param Prize $prize
     *
     * @return StrategyOutputDto
     */
    public function runStrategy(User $user, Prize $prize): StrategyOutputDto;
}
