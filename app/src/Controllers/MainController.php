<?php declare(strict_types=1);

namespace ChristelMusic\Controllers;

use ChristelMusic\ReleaseRepository;
use ChristelMusic\Releases\ReleaseProject;
use Parable\GetSet\DataCollection;

final class MainController
{
    public function __construct(
        protected DataCollection $dataCollection,
        protected ReleaseRepository $releaseRepository,
    ) {}

    public function indexAction(): void
    {
        $this->dataCollection->set('viewData', [
            'releaseProjects' => $this->releaseRepository->getAllProjects(),
        ]);
    }

    public function releaseAction(ReleaseProject $releaseProject): void
    {
        $this->dataCollection->set('viewData', [
            'releaseProject' => $releaseProject,
            'pageName' => $releaseProject->getTitle(),
        ]);
    }

}