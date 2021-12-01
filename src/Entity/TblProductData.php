<?php

namespace App\Entity;

use App\Repository\TblProductDataRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TblProductDataRepository::class)
 */
class TblProductData
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $intProductDataId;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private ?string $strProductName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $strProductDesc;

    /**
     * @ORM\Column(type="string", length=10 unique=true)
     */
    private ?string $strProductCode;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?string $dtmAdded;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?string $dtmDiscontinued;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $stmTimestamp;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $intStock;

    /**
     * @ORM\Column(type="float")
     */
    private ?float $floatPrice;

    /**
     * @return float|null
     */
    public function getFloatPrice(): ?float
    {
        return $this->floatPrice;
    }

    /**
     * @param mixed $floatPrice
     */
    public function setFloatPrice($floatPrice): void
    {
        $this->floatPrice = $floatPrice;
    }

    /**
     * @return int|null
     */
    public function getIntStock(): ?int
    {
        return $this->intStock;
    }

    /**
     * @param int|null $intStock
     */
    public function setIntStock(?int $intStock): void
    {
        $this->intStock = $intStock;
    }

    public function getIntProductDataId(): ?int
    {
        return $this->intProductDataId;
    }

    public function setIntProductDataId(int $intProductDataId): self
    {
        $this->intProductDataId = $intProductDataId;

        return $this;
    }

    public function getStrProductName(): ?string
    {
        return $this->strProductName;
    }

    public function setStrProductName(string $strProductName): self
    {
        $this->strProductName = $strProductName;

        return $this;
    }

    public function getStrProductDesc(): ?string
    {
        return $this->strProductDesc;
    }

    public function setStrProductDesc(string $strProductDesc): self
    {
        $this->strProductDesc = $strProductDesc;

        return $this;
    }

    public function getStrProductCode(): ?string
    {
        return $this->strProductCode;
    }

    public function setStrProductCode(string $strProductCode): self
    {
        $this->strProductCode = $strProductCode;

        return $this;
    }

    public function getDtmAdded(): ?string
    {
        return $this->dtmAdded;
    }

    public function setDtmAdded(string $dtmAdded): self
    {
        $this->dtmAdded = $dtmAdded;

        return $this;
    }

    public function getDtmDiscontinued(): ?string
    {
        return $this->dtmDiscontinued;
    }

    public function setDtmDiscontinued(string $dtmDiscontinued): self
    {
        $this->dtmDiscontinued = $dtmDiscontinued;

        return $this;
    }

    public function getStmTimestamp(): ?int
    {
        return $this->stmTimestamp;
    }

    public function setStmTimestamp(int $stmTimestamp): self
    {
        $this->stmTimestamp = $stmTimestamp;

        return $this;
    }
}
