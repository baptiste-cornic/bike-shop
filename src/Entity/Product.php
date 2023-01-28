<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $brand = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[ORM\Column(length: 255)]
    private ?string $productType = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $frame = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fork = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $suspension = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $brakeType = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $saddle = null;

    #[ORM\Column]
    private ?bool $isValid = false;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $creationDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updateDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getProductType(): ?string
    {
        return $this->productType;
    }

    public function setProductType(string $productType): self
    {
        $this->productType = $productType;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getFrame(): ?string
    {
        return $this->frame;
    }

    public function setFrame(?string $frame): self
    {
        $this->frame = $frame;

        return $this;
    }

    public function getFork(): ?string
    {
        return $this->fork;
    }

    public function setFork(?string $fork): self
    {
        $this->fork = $fork;

        return $this;
    }

    public function getSuspension(): ?string
    {
        return $this->suspension;
    }

    public function setSuspension(?string $suspension): self
    {
        $this->suspension = $suspension;

        return $this;
    }

    public function getBrakeType(): ?string
    {
        return $this->brakeType;
    }

    public function setBrakeType(?string $brakeType): self
    {
        $this->brakeType = $brakeType;

        return $this;
    }

    public function getSaddle(): ?string
    {
        return $this->saddle;
    }

    public function setSaddle(?string $saddle): self
    {
        $this->saddle = $saddle;

        return $this;
    }

    public function isIsValid(): ?bool
    {
        return $this->isValid;
    }

    public function setIsValid(bool $isValid): self
    {
        $this->isValid = $isValid;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    #[ORM\PrePersist]
    public function setCreationDate(): self
    {
        $this->creationDate = new \DateTime();

        return $this;
    }

    public function getUpdateDate(): ?\DateTimeInterface
    {
        return $this->updateDate;
    }

    #[ORM\PreUpdate]
    public function setUpdateDate(): self
    {
        $this->updateDate = new \DateTime();

        return $this;
    }
}
