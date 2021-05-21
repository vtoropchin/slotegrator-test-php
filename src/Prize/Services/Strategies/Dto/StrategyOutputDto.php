<?php declare(strict_types=1);


namespace Src\Prize\Services\Strategies\Dto;


/**
 * Class StrategyOutputDto
 * @package Src\Prize\Services\Strategies\Dto
 */
class StrategyOutputDto
{
    public bool $isSuccess = true;

    public ?string $error;
}
