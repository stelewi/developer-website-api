<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ShipRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShipRepository::class)]
#[ApiResource]
class Ship
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\OneToOne(inversedBy: 'ship', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private GamePlayer $player;

    #[ORM\Column]
    private float $totalCargoCapacity;

    #[ORM\Column(nullable: true)]
    private float $totalFuelCapacity;

    #[ORM\Column]
    private float $totalEnginePower;

    #[ORM\Column]
    private float $fuelAmount;

    #[ORM\OneToMany(mappedBy: 'ship', targetEntity: Recruit::class)]
    private Collection $recruits;

    public function __construct()
    {
        $this->recruits = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Ship
    {
        $this->name = $name;
        return $this;
    }

    public function getPlayer(): GamePlayer
    {
        return $this->player;
    }

    public function setPlayer(GamePlayer $player): Ship
    {
        $this->player = $player;
        return $this;
    }

    public function getTotalCargoCapacity(): float
    {
        return $this->totalCargoCapacity;
    }

    public function setTotalCargoCapacity(float $totalCargoCapacity): Ship
    {
        $this->totalCargoCapacity = $totalCargoCapacity;
        return $this;
    }

    public function getTotalFuelCapacity(): float
    {
        return $this->totalFuelCapacity;
    }

    public function setTotalFuelCapacity(float $totalFuelCapacity): Ship
    {
        $this->totalFuelCapacity = $totalFuelCapacity;
        return $this;
    }

    public function getTotalEnginePower(): float
    {
        return $this->totalEnginePower;
    }

    public function setTotalEnginePower(float $totalEnginePower): Ship
    {
        $this->totalEnginePower = $totalEnginePower;
        return $this;
    }

    public function getFuelAmount(): float
    {
        return $this->fuelAmount;
    }

    public function setFuelAmount(float $fuelAmount): Ship
    {
        $this->fuelAmount = $fuelAmount;
        return $this;
    }

    /**
     * @return Collection<int, Recruit>
     */
    public function getRecruits(): Collection
    {
        return $this->recruits;
    }

    public function addRecruit(Recruit $recruit): static
    {
        if (!$this->recruits->contains($recruit)) {
            $this->recruits->add($recruit);
            $recruit->setShip($this);
        }

        return $this;
    }

    public function removeRecruit(Recruit $recruit): static
    {
        if ($this->recruits->removeElement($recruit)) {
            // set the owning side to null (unless already changed)
            if ($recruit->getShip() === $this) {
                $recruit->setShip(null);
            }
        }

        return $this;
    }
}
