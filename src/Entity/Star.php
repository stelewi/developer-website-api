<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Dto\Position;
use App\Dto\PositionInterface;
use App\Repository\StarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StarRepository::class)]
#[ApiResource]
class Star
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column]
    private float $positionX;

    #[ORM\Column]
    private float $positionY;

    #[ORM\Column]
    private float $positionZ;

    #[ORM\OneToMany(mappedBy: 'star', targetEntity: Planet::class, orphanRemoval: true)]
    private Collection $planets;

    #[ORM\ManyToOne(inversedBy: 'stars')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Galaxy $galaxy = null;

    public function __construct()
    {
        $this->planets = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Star
    {
        $this->name = $name;
        return $this;
    }

    public function getPositionX(): float
    {
        return $this->positionX;
    }

    public function setPositionX(float $positionX): Star
    {
        $this->positionX = $positionX;
        return $this;
    }

    public function getPositionY(): float
    {
        return $this->positionY;
    }

    public function setPositionY(float $positionY): Star
    {
        $this->positionY = $positionY;
        return $this;
    }

    public function getPositionZ(): float
    {
        return $this->positionZ;
    }

    public function setPositionZ(float $positionZ): Star
    {
        $this->positionZ = $positionZ;
        return $this;
    }

    public function getPosition(): PositionInterface
    {
        return Position::create(
            $this->positionX,
            $this->positionY,
            $this->positionZ
        );
    }

    /**
     * @return Collection<int, Planet>
     */
    public function getPlanets(): Collection
    {
        return $this->planets;
    }

    public function addPlanet(Planet $planet): static
    {
        if (!$this->planets->contains($planet)) {
            $this->planets->add($planet);
            $planet->setStar($this);
        }

        return $this;
    }

    public function removePlanet(Planet $planet): static
    {
        if ($this->planets->removeElement($planet)) {
            // set the owning side to null (unless already changed)
            if ($planet->getStar() === $this) {
                $planet->setStar(null);
            }
        }

        return $this;
    }

    public function getGalaxy(): ?Galaxy
    {
        return $this->galaxy;
    }

    public function setGalaxy(?Galaxy $galaxy): static
    {
        $this->galaxy = $galaxy;

        return $this;
    }
}
