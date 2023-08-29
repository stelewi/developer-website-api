<?php

namespace App\State\User;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\AnonymousUserRequest;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Gesdinet\JWTRefreshTokenBundle\Generator\RefreshTokenGeneratorInterface;
use Gesdinet\JWTRefreshTokenBundle\Model\RefreshTokenManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AnonymousUserRequestStateProcessor implements ProcessorInterface
{
    const ANON_USER_REFRESH_TOKEN_TTL = 2592000;

    protected EntityManagerInterface $entityManager;
    protected UserPasswordHasherInterface $passwordHasher;
    protected JWTTokenManagerInterface $JWTTokenManager;
    private RefreshTokenGeneratorInterface $refreshTokenGenerator;
    private RefreshTokenManagerInterface $refreshTokenManager;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        JWTTokenManagerInterface $JWTTokenManager,
        RefreshTokenGeneratorInterface $refreshTokenGenerator,
        RefreshTokenManagerInterface $refreshTokenManager
    ) {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
        $this->JWTTokenManager = $JWTTokenManager;
        $this->refreshTokenGenerator = $refreshTokenGenerator;
        $this->refreshTokenManager = $refreshTokenManager;
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $anonymousUserRequest = $data;

        if(!$anonymousUserRequest instanceof AnonymousUserRequest || !$operation instanceof Post)
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

        $refreshToken = $this->refreshTokenGenerator->createForUserWithTtl($user, self::ANON_USER_REFRESH_TOKEN_TTL);
        $this->refreshTokenManager->save($refreshToken);

        $anonymousUserRequest->setRefreshToken($refreshToken->getRefreshToken());

        return $anonymousUserRequest;
    }
}
