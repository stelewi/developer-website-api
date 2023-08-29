<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\RecruitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecruitRepository::class)]
#[ApiResource]
class Recruit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $dailyRate = null;

    #[ORM\Column]
    private ?int $skillWeapons = null;

    #[ORM\Column]
    private ?int $skillEngineer = null;

    #[ORM\Column]
    private ?int $skillCharm = null;

    #[ORM\Column]
    private ?int $skillLoyalty = null;

    #[ORM\ManyToOne(inversedBy: 'recruits')]
    private ?Ship $ship = null;

    #[ORM\ManyToOne(inversedBy: 'recruits')]
    private ?Station $station = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getDailyRate(): ?string
    {
        return $this->dailyRate;
    }

    public function setDailyRate(string $dailyRate): static
    {
        $this->dailyRate = $dailyRate;

        return $this;
    }

    public function getSkillWeapons(): ?int
    {
        return $this->skillWeapons;
    }

    public function setSkillWeapons(int $skillWeapons): static
    {
        $this->skillWeapons = $skillWeapons;

        return $this;
    }

    public function getSkillEngineer(): ?int
    {
        return $this->skillEngineer;
    }

    public function setSkillEngineer(int $skillEngineer): static
    {
        $this->skillEngineer = $skillEngineer;

        return $this;
    }

    public function getSkillCharm(): ?int
    {
        return $this->skillCharm;
    }

    public function setSkillCharm(int $skillCharm): static
    {
        $this->skillCharm = $skillCharm;

        return $this;
    }

    public function getSkillLoyalty(): ?int
    {
        return $this->skillLoyalty;
    }

    public function setSkillLoyalty(int $skillLoyalty): static
    {
        $this->skillLoyalty = $skillLoyalty;

        return $this;
    }

    public function getShip(): ?Ship
    {
        return $this->ship;
    }

    public function setShip(?Ship $ship): static
    {
        $this->ship = $ship;

        return $this;
    }

    public function getStation(): ?Station
    {
        return $this->station;
    }

    public function setStation(?Station $station): Recruit
    {
        $this->station = $station;
        return $this;
    }
}
