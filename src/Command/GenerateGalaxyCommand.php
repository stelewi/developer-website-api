<?php

namespace App\Command;

use App\Service\Galaxy\GalaxyGenerator;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:generate-galaxy',
    description: 'Add a short description for your command',
)]
class GenerateGalaxyCommand extends Command
{
    protected GalaxyGenerator $galaxyGenerator;

    public function __construct(GalaxyGenerator $galaxyGenerator)
    {
        parent::__construct();
        $this->galaxyGenerator = $galaxyGenerator;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('galaxyName', InputArgument::REQUIRED, 'Galaxy Name')
            ->addArgument('numStars', InputArgument::OPTIONAL, 'Number of Stars')
            ->addArgument('minPlanetsPerStar', InputArgument::OPTIONAL, 'Min Planets per Star')
            ->addArgument('maxPlanetsPerStar', InputArgument::OPTIONAL, 'Max Planets per Star')
            ->addArgument('maxStationsPerPlanet', InputArgument::OPTIONAL, 'Max Stations per Planet')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $galaxyName = $input->getArgument('galaxyName');
        $numStars = (int) ($input->getArgument('numStars') ?? 100);
        $minPlanetsPerStar = (int) ($input->getArgument('minPlanetsPerStar') ?? 2);
        $maxPlanetsPerStar = (int) ($input->getArgument('maxPlanetsPerStar') ?? 12);
        $maxStationsPerPlanet = (int) ($input->getArgument('maxStationsPerPlanet') ?? 2);

        $io->info("Num stars: $numStars");

        $this->galaxyGenerator->generateGalaxy(
            $galaxyName,
            $numStars,
            $minPlanetsPerStar,
            $maxPlanetsPerStar,
            $maxStationsPerPlanet
        );

        $io->success('Galaxy generated');

        return Command::SUCCESS;
    }
}
