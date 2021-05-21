<?php declare(strict_types=1);


namespace Src\User\Services;


use Src\Core\Application;
use Src\Core\Services\EncryptorService;

/**
 * Class AuthenticateService
 * @package Src\User\Service
 */
class AuthenticateService
{
    protected UserService $userService;
    protected EncryptorService $encryptorService;

    /**
     * AuthenticateService constructor.
     *
     * @param UserService      $userService
     * @param EncryptorService $encryptorService
     */
    public function __construct(UserService $userService, EncryptorService $encryptorService)
    {
        $this->userService = $userService;
        $this->encryptorService = $encryptorService;
    }

    /**
     * @param string $login
     * @param string $password
     *
     * @return bool
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function auth(string $login, string $password): bool
    {
        $result = false;
        $user = $this->userService->getUserByLogin($login);
        if ($user !== null) {
            $passwordHash = $user->getPassword();
            $key = Application::getApp()->getConfig('[application][encryptionKey]');
            $decryptedPassword = $this->encryptorService->decrypt($key, $passwordHash);

            if ($decryptedPassword === $password) {
                $result = true;
                Application::getApp()->getContainer()->set('currentUserId', $user->getId());
            }
        }

        return $result;
    }
}
