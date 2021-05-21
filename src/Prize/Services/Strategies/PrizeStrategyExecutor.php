<?php declare(strict_types=1);


namespace Src\Prize\Services\Strategies;


use DI\Container;
use Src\Prize\Dal\Entity\Prize;
use Src\User\Dal\Entity\User;

/**
 * Class PrizeStrategyExecutor
 * @package Src\Prize\Services\Strategies
 */
class PrizeStrategyExecutor
{
    protected array $errors = [];
    protected Container $container;
    protected PrizeStrategiesContext $strategiesContext;

    public function __construct(Container $container, PrizeStrategiesContext $strategiesContext)
    {
        $this->container = $container;
        $this->strategiesContext = $strategiesContext;
    }

    /**
     * @param User  $user
     * @param Prize $prize
     *
     * @return bool
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function runAllStrategies(User $user, Prize $prize): bool
    {
        foreach ($this->strategiesContext->getStrategies() as $strategyClass) {
            /** @var PrizeStrategyInterface $strategy */
            $strategy = $this->container->make($strategyClass);
            $result = $strategy->runStrategy($user, $prize);

            if (!$result->isSuccess) {
                $this->errors[] = $result->error;
            }
        }

        return empty($this->errors);
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
