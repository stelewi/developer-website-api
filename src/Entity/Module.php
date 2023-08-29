<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ModuleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModuleRepository::class)]
#[ApiResource]
class Module
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private ?float $enginePower = null;

    #[ORM\Column]
    private ?float $cargoCapacity = null;

    #[ORM\Column]
    private ?float $fuelCapacity = null;

    #[ORM\Column]
    private ?float $weaponPower = null;

    #[ORM\Column(length: 255)]
    private ?string $shieldType = null;

    #[ORM\Column]
    private ?float $shieldPower = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getEnginePower(): ?float
    {
        return $this->enginePower;
    }

    public function setEnginePower(float $enginePower): static
    {
        $this->enginePower = $enginePower;

        return $this;
    }

    public function getCargoCapacity(): ?float
    {
        return $this->cargoCapacity;
    }

    public function setCargoCapacity(float $cargoCapacity): static
    {
        $this->cargoCapacity = $cargoCapacity;

        return $this;
    }

    public function getFuelCapacity(): ?float
    {
        return $this->fuelCapacity;
    }

    public function setFuelCapacity(?float $fuelCapacity): Module
    {
        $this->fuelCapacity = $fuelCapacity;
        return $this;
    }

    public function getWeaponPower(): ?float
    {
        return $this->weaponPower;
    }

    public function setWeaponPower(float $weaponPower): static
    {
        $this->weaponPower = $weaponPower;

        return $this;
    }

    public function getShieldType(): ?string
    {
        return $this->shieldType;
    }

    public function setShieldType(string $shieldType): static
    {
        $this->shieldType = $shieldType;

        return $this;
    }

    public function getShieldPower(): ?float
    {
        return $this->shieldPower;
    }

    public function setShieldPower(float $shieldPower): static
    {
        $this->shieldPower = $shieldPower;

        return $this;
    }
}
