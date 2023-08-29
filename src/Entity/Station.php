<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\StationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StationRepository::class)]
#[ApiResource]
class Station
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\ManyToOne(inversedBy: 'stations')]
    #[ORM\JoinColumn(nullable: false)]
    private Planet $planet;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\OneToMany(mappedBy: 'station', targetEntity: Recruit::class)]
    private Collection $recruits;

    public function __construct()
    {
        $this->recruits = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPlanet(): Planet
    {
        return $this->planet;
    }

    public function setPlanet(Planet $planet): static
    {
        $this->planet = $planet;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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
