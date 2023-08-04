<?php

namespace App\Dto;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Entity\User;
use App\State\User\AnonymousUserRequestStateProcessor;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    operations: [
        new Get(),
        new Post(
            processor: AnonymousUserRequestStateProcessor::class
        )
    ],
    normalizationContext: ['groups' => ['AnonymousUserRequest:read', 'User:read']],
    denormalizationContext: ['groups' => ['AnonymousUserRequest:write']],
)]
class AnonymousUserRequest
{

    #[Groups(['AnonymousUserRequest:read'])]
    protected ?string $id = null;

    #[Groups(['AnonymousUserRequest:read'])]
    protected ?User $newAnonymousUser = null;
    #[Groups(['AnonymousUserRequest:read'])]
    protected ?string $jwtToken = null;

    #[Groups(['AnonymousUserRequest:read'])]
    protected ?string $refreshToken = null;

    /**
     * @param string|null $id
     */
    public function __construct(?string $id = null)
    {
        $this->id = $id ?? Uuid::uuid4()->toString();
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return User|null
     */
    public function getNewAnonymousUser(): ?User
    {
        return $this->newAnonymousUser;
    }

    /**
     * @param User|null $newAnonymousUser
     */
    public function setNewAnonymousUser(?User $newAnonymousUser): void
    {
        $this->newAnonymousUser = $newAnonymousUser;
    }

    /**
     * @return string|null
     */
    public function getJwtToken(): ?string
    {
        return $this->jwtToken;
    }

    /**
     * @param string|null $jwtToken
     */
    public function setJwtToken(?string $jwtToken): void
    {
        $this->jwtToken = $jwtToken;
    }

    /**
     * @return string|null
     */
    public function getRefreshToken(): ?string
    {
        return $this->refreshToken;
    }

    /**
     * @param string|null $refreshToken
     */
    public function setRefreshToken(?string $refreshToken): void
    {
        $this->refreshToken = $refreshToken;
    }

}
