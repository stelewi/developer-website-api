<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\GalaxyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GalaxyRepository::class)]
#[ApiResource]
class Galaxy
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\OneToMany(mappedBy: 'galaxy', targetEntity: Star::class, orphanRemoval: true)]
    private Collection $stars;

    public function __construct()
    {
        $this->stars = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Galaxy
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Collection<int, Star>
     */
    public function getStars(): Collection
    {
        return $this->stars;
    }

    public function addStar(Star $star): static
    {
        if (!$this->stars->contains($star)) {
            $this->stars->add($star);
            $star->setGalaxy($this);
        }

        return $this;
    }

    public function removeStar(Star $star): static
    {
        if ($this->stars->removeElement($star)) {
            // set the owning side to null (unless already changed)
            if ($star->getGalaxy() === $this) {
                $star->setGalaxy(null);
            }
        }

        return $this;
    }
}
