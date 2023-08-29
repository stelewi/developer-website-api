<?php

namespace App\State\GamePlayer;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\GamePlayer;
use App\Entity\User;
use App\Service\ClockInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class GamePlayerStateProcessor implements ProcessorInterface
{
    protected Security $security;
    protected EntityManagerInterface $entityManager;
    protected UserPasswordHasherInterface $passwordHasher;
    protected ClockInterface $clock;

    public function __construct(Security $security, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher, ClockInterface $clock)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
        $this->clock = $clock;
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $user = $this->security->getUser();
        $gamePlayer = $data;

        if(!$user instanceof User)
        {
            throw new \Exception('unexpected user');
        }

        if(!$gamePlayer instanceof GamePlayer || !$operation instanceof Post)
        {
            throw new \Exception('not supported');
        }

        if($gamePlayer->getStatus() !== GamePlayer::STATUS_REQUEST_CREATE)
        {
            throw new \Exception('unexpected status');
        }

        $playerToken = $this->passwordHasher->hashPassword($user, random_bytes(10));
        $gamePlayer->setPlayerToken($playerToken);
        $gamePlayer->setUser($user);
        $gamePlayer->setStatus(GamePlayer::STATUS_PENDING_JOIN);
        $gamePlayer->setCreatedAt($this->clock->now());

        $this->entityManager->persist($gamePlayer);
        $this->entityManager->flush($gamePlayer);

        return $gamePlayer;
    }
}
