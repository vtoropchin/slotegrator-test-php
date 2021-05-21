<?php declare(strict_types=1);


namespace Src\Prize\Dal\Entity;

use Doctrine\ORM\Mapping as ORM;
use Src\Prize\Dal\Enum\PrizeTypeEnum;
use Src\Prize\Exceptions\EmptyPrizeNameException;
use Src\Prize\Exceptions\PrizeNameIsTooLoonException;
use Src\Prize\Exceptions\PrizeNumbersIsLessThanZeroException;
use Src\Prize\Exceptions\WrongPrizeTypeException;

/**
 * @ORM\Entity
 * @ORM\Table(name="prizes")
 * @ORM\Entity(repositoryClass="Src\Prize\Dal\Repository\PrizeRepository")
 */
class Prize
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected int $id;

    /**
     * @ORM\Column(type="string")
     */
    protected string $name;

    /**
     * @ORM\Column(name="available_number", type="integer", nullable=true)
     */
    protected ?int $availableNumber = null;

    /**
     * @ORM\Column(type="PrizeTypeEnum", nullable=false, options={"default"="money"})
     */
    protected string $type = PrizeTypeEnum::MONEY;

    public function __construct(string $type, string $name, ?int $availableNumber = null)
    {
        $this->setType($type);
        $this->setName($name);
        $this->setAvailableNumber($availableNumber);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->validateType($type);
        $this->type = $type;
    }

    /**
     * @param string $type
     */
    protected function validateType(string $type): void
    {
        if (!PrizeTypeEnum::hasValue($type)) {
            throw new WrongPrizeTypeException();
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->validateName($name);
        $this->name = $name;
    }

    protected function validateName(string $name): void
    {
        $len = mb_strlen($name);
        if ($len === 0) {
            throw new EmptyPrizeNameException();
        }

        if ($len > 255) {
            throw new PrizeNameIsTooLoonException();
        }
    }

    /**
     * @return int|null
     */
    public function getAvailableNumber(): ?int
    {
        return $this->availableNumber;
    }

    /**
     * @param int|null $availableNumber
     */
    public function setAvailableNumber(?int $availableNumber): void
    {
        $this->validateAvailableNumber($availableNumber);
        $this->availableNumber = $availableNumber;
    }

    /**
     * @param int|null $availableNumber
     */
    protected function validateAvailableNumber(?int $availableNumber): void
    {
        if ($availableNumber < 0) {
            throw new PrizeNumbersIsLessThanZeroException();
        }
    }
}
