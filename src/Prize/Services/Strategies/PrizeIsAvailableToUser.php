<?php declare(strict_types=1);


namespace Src\Prize\Services\Strategies;


use Src\Prize\Dal\Entity\Prize;
use Src\Prize\Services\Strategies\Dto\StrategyOutputDto;
use Src\User\Dal\Entity\User;

/**
 * Class PrizeIsAvailableToUser
 * @package Src\Prize\Services\Strategies
 */
class PrizeIsAvailableToUser implements PrizeStrategyInterface
{
    public function runStrategy(User $user, Prize $prize): StrategyOutputDto
    {
        // Check if a user can get this prize
        return new StrategyOutputDto();
    }
}
