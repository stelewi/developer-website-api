<?php

namespace App\State\User;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;

class MeStateProvider implements ProviderInterface
{
    protected Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $user = $this->security->getUser();

        if($user instanceof User) {
            return $user;
        }

        return null;
    }
}
