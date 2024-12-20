<?php declare(strict_types=1);

namespace ChristelMusic\Commands;

use ChristelMusic\ReleaseRepository;
use Parable\Console\Command;

final class WarmupCommand extends Command
{
    public function __construct(protected ReleaseRepository $releaseRepository)
    {
        $this->setName('warmup');
        $this->setDescription('Warmup christelmusic.nl');
    }

    public function run(): void
    {
        $this->output->writeln('Generating sheet music cache...');

        foreach ($this->releaseRepository->getAllProjects() as $project) {
            $this->output->writeln("- {$project->getTitle()}");
            $this->output->write("  ");

            foreach ($project->getReleaseItems() as $releaseItem) {
                $this->output->writeln("  > {$releaseItem->getTitle()}");

                foreach ($releaseItem->getSheetMusics() as $sheetMusic) {
                    $this->output->writeln("    ! {$sheetMusic->getPdfPath()}");
                    $sheetMusic->getBase64encodedPngData();
                    $sheetMusic->getNumberOfPages();
                }
            }

            $this->output->newline();
        }
    }
}