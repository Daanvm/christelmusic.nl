<?php declare(strict_types=1);

namespace ChristelMusic\Controllers;

use ChristelMusic\Releases\ReleaseProject;
use Parable\GetSet\DataCollection;

final class MainController
{
    public function __construct(protected DataCollection $dataCollection) {}

    public function indexAction(): void
    {
    }

    public function releaseAction(ReleaseProject $releaseProject): void
    {
        $this->dataCollection->set('viewData', [
            'releaseProject' => $releaseProject,
            'pageName' => $releaseProject->getTitle(),
        ]);
    }

}