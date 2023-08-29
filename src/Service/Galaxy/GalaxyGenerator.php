<?php

namespace App\Service\Galaxy;

use App\Entity\Galaxy;
use App\Entity\Star;
use App\Service\Planet\PlanetNames;
use App\Service\Star\StarNames;
use Doctrine\ORM\EntityManagerInterface;

class GalaxyGenerator
{
    const AVE_DISTANCE_BETWEEN_STARS_LIGHT_YEARS = 60;
    const ONE_DEVIATION_BETWEEN_STARS_LIGHT_YEARS = 50;
    const MILKY_WAY_RADIUS = 50000;
    const DEGREES_TO_RADIANS = M_PI * 2 / 360;

    protected StarNames $starNames;
    protected PlanetNames $planetNames;
    protected EntityManagerInterface $em;
    protected PlanetGenerator $planetGenerator;

    public function __construct(
        StarNames $starNames,
        PlanetNames $planetNames,
        EntityManagerInterface $em,
        PlanetGenerator $planetGenerator
    ) {
        $this->starNames = $starNames;
        $this->planetNames = $planetNames;
        $this->em = $em;
        $this->planetGenerator = $planetGenerator;
    }

    public function generateGalaxy(
        string $galaxyName,
        int $numStars,
        int $minPlanetsPerStar,
        int $maxPlanetsPerStar,
        int $maxStationsPerPlanet,
    ): Galaxy {

        $starNames = $this->starNames->getNames();
        $planetNames = $this->planetNames->getNames();

        $galaxy = new Galaxy();
        $galaxy->setName($galaxyName);
        $this->em->persist($galaxy);

        // init star angle at 45 degrees
        // create arc 20 degrees (like a spiral arm) of randomly placed stars
        $initAngle = (M_PI / 4);
        $angleIncrement = (20 / $numStars) * self::DEGREES_TO_RADIANS;

        // center of galaxy is 0,0,0
        for($i = 0; $i < $numStars; $i++) {
            $star = new Star();

            $angle = $initAngle + ($angleIncrement * $i);
            $distanceFromCenter = self::MILKY_WAY_RADIUS - (($numStars - $i) * self::AVE_DISTANCE_BETWEEN_STARS_LIGHT_YEARS);

            $posX = sin($angle) * $distanceFromCenter;
            $posY = 0;
            $posZ = cos($angle) * $distanceFromCenter;

            $randDeviation = fn() => (
                rand(0, 2 * self::ONE_DEVIATION_BETWEEN_STARS_LIGHT_YEARS) -
                self::ONE_DEVIATION_BETWEEN_STARS_LIGHT_YEARS
            );

            $posX += $randDeviation();
            $posY += $randDeviation();
            $posZ += $randDeviation();

            $star->setName($starNames[$i]);
            $star->setGalaxy($galaxy);
            $star->setPositionX($posX);
            $star->setPositionY($posY);
            $star->setPositionZ($posZ);

            $this->em->persist($star);

            $this->planetGenerator->generatePlanetsForStar(
                $star,
                $minPlanetsPerStar,
                $maxPlanetsPerStar,
                $maxStationsPerPlanet
            );
        }

        $this->em->flush();

        return $galaxy;
    }
}
