<?php

declare(strict_types=1);

namespace WoohooLabs\Harmony\Condition;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function strpos;

class PathPrefixCondition implements ConditionInterface
{
    /** @var string[] */
    protected array $pathPrefixes = [];

    /**
     * @param string[] $pathPrefixes
     */
    public function __construct(array $pathPrefixes)
    {
        $this->pathPrefixes = $pathPrefixes;
    }

    public function evaluate(ServerRequestInterface $request, ResponseInterface $response): bool
    {
        foreach ($this->pathPrefixes as $pathPrefix) {
            if (strpos($request->getUri()->getPath(), $pathPrefix) === 0) {
                return true;
            }
        }

        return false;
    }
}
