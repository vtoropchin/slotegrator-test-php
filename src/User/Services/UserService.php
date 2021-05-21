<?php declare(strict_types=1);


namespace Src\User\Services;


use Doctrine\ORM\EntityManagerInterface;
use Src\Core\Application;
use Src\Core\Services\EncryptorService;
use Src\Prize\Dal\Entity\Prize;
use Src\Prize\Dal\Entity\Thing;
use Src\Prize\Dal\Enum\PrizeTypeEnum;
use Src\User\Dal\Entity\User;
use Src\User\Dal\Repository\UserRepository;

/**
 * Class UserService
 * @package Src\User\Service
 */
class UserService
{
    protected EncryptorService $encryptorService;

    protected EntityManagerInterface $entityManager;

    protected UserRepository $userRepository;

    /**
     * UserService constructor.
     *
     * @param EncryptorService       $encryptorService
     * @param EntityManagerInterface $entityManager
     * @param UserRepository         $userRepository
     */
    public function __construct(
        EncryptorService $encryptorService,
        EntityManagerInterface $entityManager,
        UserRepository $userRepository
    ) {
        $this->encryptorService = $encryptorService;
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
    }

    /**
     * @param string $login
     * @param        $password
     *
     * @return bool
     */
    public function registerUser(string $login, $password): bool
    {
        $result = false;

        $app = Application::getApp();
        $password = $this->encryptorService->encrypt($app->getConfig('[application][encryptionKey]'), $password);

        $user = new User($login, $password);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $result;
    }

    /**
     * @param int $userId
     *
     * @return User|null
     */
    public function getUserById(int $userId): ?User
    {
        return $this->userRepository->findById($userId);
    }

    /**
     * @param string $login
     *
     * @return User|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getUserByLogin(string $login): ?User
    {
        return $this->userRepository->getUserByLogin($login);
    }

    /**
     * @return User|null
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function getCurrentUser(): ?User
    {
        $userId = Application::getApp()->getContainer()->get('currentUserId');
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $userId ? $this->userRepository->find($userId) : null;
    }
}
