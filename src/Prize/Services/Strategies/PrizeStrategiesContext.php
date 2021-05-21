<?php declare(strict_types=1);


namespace Src\Prize\Services\Strategies;


/**
 * Class PrizeStrategiesContext
 * @package Src\Prize\Services\Strategies
 */
class PrizeStrategiesContext
{
    protected array $strategies = [
        PrizeIsAvailableToUser::class,
        ReservePrizeStrategy::class,
    ];

    /**
     * @return PrizeStrategyInterface[]
     */
    public function getStrategies(): array
    {
        return $this->strategies;
    }
}
