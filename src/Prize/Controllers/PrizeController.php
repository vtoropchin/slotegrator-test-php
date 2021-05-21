<?php declare(strict_types=1);


namespace Src\Prize\Controllers;


use Src\Core\Http\Controllers\Controller;
use Src\Prize\Services\PrizeService;

/**
 * Class PrizeController
 * @package Src\Prize\Controllers
 */
class PrizeController extends Controller
{
    /**
     * @var PrizeService
     */
    protected PrizeService $prizeService;

    public function __construct(PrizeService $prizeService)
    {
        $this->prizeService = $prizeService;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \JsonException
     * @throws \Src\User\Exceptions\UnauthorizedHttpException
     * @throws \Src\User\Exceptions\UserDoesNotExist
     */
    public function getRandomPrize(): \Symfony\Component\HttpFoundation\Response
    {
        $prize = $this->prizeService->addRandomPrizeToCurrentUser();

        return $this->success(
            [
                'id'        => $prize->getId(),
                'prizeType' => $prize->getType(),
                'name'      => $prize->getName(),
            ]
        );
    }
}
