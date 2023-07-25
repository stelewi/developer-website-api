<?php

namespace App\State\User;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\AnonymousUserRequest;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AnonymousUserRequestStateProcessor implements ProcessorInterface
{
    protected EntityManagerInterface $entityManager;

    protected UserPasswordHasherInterface $passwordHasher;

    protected JWTTokenManagerInterface $JWTTokenManager;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        JWTTokenManagerInterface $JWTTokenManager
    ) {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
        $this->JWTTokenManager = $JWTTokenManager;
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $anonymousUserRequest = $data;

        if(!$anonymousUserRequest instanceof AnonymousUserRequest)
        {
            throw new \Exception('not supported');
        }

        // Only supports post operations
        if(!$operation instanceof Post)
        {
            throw new \Exception('not supported');
        }

        $user = new User();
        $user->setIsAnonymous(true);
        $user->setUsername($anonymousUserRequest->getUsername());

        $randomPassword = random_bytes(10);
        $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            $randomPassword
        ));

        $this->entityManager->persist($user);
        $this->entityManager->flush($user);

        $anonymousUserRequest->setNewAnonymousUser($user);
        $anonymousUserRequest->setJwtToken($this->JWTTokenManager->create($user));

        return $anonymousUserRequest;
    }
}
