<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\GameRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
#[ApiResource]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column]
    private ?\DateTimeImmutable $startedAt = null;

    #[ORM\Column(length: 255)]
    private string $status;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private Galaxy $galaxy;

    public function getId(): int
    {
        return $this->id;
    }

    public function getStartedAt(): ?\DateTimeImmutable
    {
        return $this->startedAt;
    }

    public function setStartedAt(\DateTimeImmutable $startedAt): static
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getGalaxy(): Galaxy
    {
        return $this->galaxy;
    }

    public function setGalaxy(Galaxy $galaxy): static
    {
        $this->galaxy = $galaxy;

        return $this;
    }
}
