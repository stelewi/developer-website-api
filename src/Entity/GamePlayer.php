<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\State\GamePlayer\GamePlayerStateProcessor;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    operations: [
        new Get(
            normalizationContext: ['groups' => ['GamePlayer:read']],
        ),
        new Post(
            normalizationContext: ['groups' => ['GamePlayer:read', 'GamePlayer:read_player_token']],
            denormalizationContext: ['groups' => ['GamePlayer:write']],
            processor: GamePlayerStateProcessor::class
        )
    ]
)]
#[ORM\Entity()]
class GamePlayer
{
    const STATUS_REQUEST_CREATE = 'request-create';
    const STATUS_PENDING_JOIN = 'pending-join-game';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['GamePlayer:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['GamePlayer:read'])]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    #[Groups(['GamePlayer:read_player_token'])]
    private ?string $playerToken = null;

    #[ORM\OneToOne(mappedBy: 'player', cascade: ['persist', 'remove'])]
    #[Groups(['GamePlayer:read'])]
    private ?GamePlayerScore $score = null;

    #[ORM\Column(length: 255)]
    #[Groups(['GamePlayer:read', 'GamePlayer:write'])]
    private ?string $status = null;

    #[ORM\Column]
    #[Groups(['GamePlayer:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\OneToOne(mappedBy: 'player', cascade: ['persist', 'remove'])]
    private ?Ship $ship = null;

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

    public function getScore(): ?GamePlayerScore
    {
        return $this->score;
    }

    public function setScore(GamePlayerScore $score): static
    {
        // set the owning side of the relation if necessary
        if ($score->getPlayer() !== $this) {
            $score->setPlayer($this);
        }

        $this->score = $score;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getShip(): ?Ship
    {
        return $this->ship;
    }

    public function setShip(Ship $ship): static
    {
        // set the owning side of the relation if necessary
        if ($ship->getPlayer() !== $this) {
            $ship->setPlayer($this);
        }

        $this->ship = $ship;

        return $this;
    }
}
