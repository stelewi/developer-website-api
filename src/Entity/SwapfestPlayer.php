<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SwapfestPlayerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SwapfestPlayerRepository::class)]
#[ApiResource]
class SwapfestPlayer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    private ?string $playerToken = null;

    #[ORM\OneToOne(mappedBy: 'player', cascade: ['persist', 'remove'])]
    private ?SwapfestPlayerScore $score = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getPlayerToken(): ?string
    {
        return $this->playerToken;
    }

    public function setPlayerToken(string $playerToken): static
    {
        $this->playerToken = $playerToken;

        return $this;
    }

    public function getScore(): ?SwapfestPlayerScore
    {
        return $this->score;
    }

    public function setScore(SwapfestPlayerScore $score): static
    {
        // set the owning side of the relation if necessary
        if ($score->getPlayer() !== $this) {
            $score->setPlayer($this);
        }

        $this->score = $score;

        return $this;
    }
}
