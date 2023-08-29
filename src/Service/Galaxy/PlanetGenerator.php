<?php

namespace App\Service\Galaxy;

use App\Entity\Star;
use Doctrine\ORM\EntityManagerInterface;

class PlanetGenerator
{
    protected EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function generatePlanetsForStar(
        Star $star,
        int $minPlanetsPerStar,
        int $maxPlanetsPerStar,
        int $maxStationsPerPlanet
    ) {





    }
}
