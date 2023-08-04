<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Repository\UserRepository;
use App\State\User\MeStateProvider;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            security: "is_granted('ROLE_ADMIN') or object == user"
        ),
        new Get(
            uriTemplate: '/me',
            provider: MeStateProvider::class
        )
    ],
    normalizationContext: ['groups' => ['User:read']]
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['User:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['User:read'])]
    private ?string $firstName = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['User:read'])]
    private ?string $lastName = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(['User:read'])]
    private string $username;

    #[ORM\Column]
    #[Groups(['User:read'])]
    private ?bool $isAnonymous = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $password = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getIsAnonymous(): ?bool
    {
        return $this->isAnonymous;
    }

    public function setIsAnonymous(bool $isAnonymous): static
    {
        $this->isAnonymous = $isAnonymous;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Keep this simple for now, only two roles: anonymous and standard user...
     * @return string[]
     */
    public function getRoles(): array
    {
        return [
            ...$this->isAnonymous ? [] : ['ROLE_FULL_ACCOUNT_USER'],
            'ROLE_USER'
        ];
    }

    public function eraseCredentials(): void
    {
        // password already hashed!
        // nothing to do here
    }

    public function getUserIdentifier(): string
    {
        return $this->username;
    }

}
