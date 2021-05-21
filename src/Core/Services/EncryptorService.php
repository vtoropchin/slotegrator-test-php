<?php declare(strict_types=1);


namespace Src\Core\Services;


use Illuminate\Encryption\Encrypter;

/**
 * Class EncryptorService
 * @package App\Core\Services
 */
class EncryptorService
{
    protected const CIPHER = 'AES-256-CBC';

    /**
     * @return string
     */
    public function generateKey(): string
    {
        $byteKey = Encrypter::generateKey(self::CIPHER);

        return base64_encode($byteKey);
    }

    /**
     * @param string $key
     * @param        $value
     *
     * @return string
     */
    public function encrypt(string $key, $value): string
    {
        $key = base64_decode($key);
        $encryptor = new Encrypter($key, self::CIPHER);

        return $encryptor->encrypt($value);
    }

    /**
     * @param string $key
     * @param string $payload
     *
     * @return mixed
     */
    public function decrypt(string $key, string $payload)
    {
        $key = base64_decode($key);
        $encryptor = new Encrypter($key, self::CIPHER);

        return $encryptor->decrypt($payload);
    }
}
