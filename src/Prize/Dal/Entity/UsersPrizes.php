<?php declare(strict_types=1);


namespace Src\Prize\Dal\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users_prizes")
 */
class UsersPrizes
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected int $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected int $userId;

    /**
     * @ORM\Column(type="integer")
     */
    protected int $prizeId;

    /**
     * @ORM\Column(type="integer")
     */
    protected int $prizeNumber;

    /**
     * UsersPrizes constructor.
     *
     * @param int $userId
     * @param int $prizeId
     * @param int $prizeNumber
     */
    public function __construct(int $userId, int $prizeId, int $prizeNumber)
    {
        $this->setUserId($userId);
        $this->setPrizeId($prizeId);
        $this->setPrizeNumber($prizeNumber);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getPrizeId(): int
    {
        return $this->prizeId;
    }

    /**
     * @param int $prizeId
     */
    public function setPrizeId(int $prizeId): void
    {
        $this->prizeId = $prizeId;
    }

    /**
     * @return int
     */
    public function getPrizeNumber(): int
    {
        return $this->prizeNumber;
    }

    /**
     * @param int $prizeNumber
     */
    public function setPrizeNumber(int $prizeNumber): void
    {
        $this->prizeNumber = $prizeNumber;
    }
}
