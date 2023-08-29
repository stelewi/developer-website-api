<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PlanetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlanetRepository::class)]
#[ApiResource]
class Planet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column]
    private float $distanceFromStar;

    #[ORM\Column]
    private float $angleToStar;

    #[ORM\ManyToOne(inversedBy: 'planets')]
    #[ORM\JoinColumn(nullable: false)]
    private Star $star;

    #[ORM\OneToMany(mappedBy: 'planet', targetEntity: Station::class, orphanRemoval: true)]
    private Collection $stations;

    public function __construct()
    {
        $this->stations = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Planet
    {
        $this->name = $name;
        return $this;
    }

    public function getDistanceFromStar(): float
    {
        return $this->distanceFromStar;
    }

    public function setDistanceFromStar(float $distanceFromStar): Planet
    {
        $this->distanceFromStar = $distanceFromStar;
        return $this;
    }

    public function getAngleToStar(): float
    {
        return $this->angleToStar;
    }

    public function setAngleToStar(float $angleToStar): Planet
    {
        $this->angleToStar = $angleToStar;
        return $this;
    }

    public function getStar(): Star
    {
        return $this->star;
    }

    public function setStar(Star $star): Planet
    {
        $this->star = $star;
        return $this;
    }

    /**
     * @return Collection<int, Station>
     */
    public function getStations(): Collection
    {
        return $this->stations;
    }

    public function addStation(Station $station): static
    {
        if (!$this->stations->contains($station)) {
            $this->stations->add($station);
            $station->setPlanet($this);
        }

        return $this;
    }

    public function removeStation(Station $station): static
    {
        if ($this->stations->removeElement($station)) {
            // set the owning side to null (unless already changed)
            if ($station->getPlanet() === $this) {
                $station->setPlanet(null);
            }
        }

        return $this;
    }
}
