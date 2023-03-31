<?php declare(strict_types=1);

namespace ChristelMusic;

use ChristelMusic\Releases\Landslide;
use ChristelMusic\Releases\OnlyTheYoung;
use ChristelMusic\Releases\ReleaseItem;
use ChristelMusic\Releases\ReleaseItemAlbum;
use ChristelMusic\Releases\ReleaseProject;
use ChristelMusic\Releases\Watershed;

final class ReleaseRepository
{
    /**
     * @return ReleaseProject[]
     */
    public function getAllProjects(): array
    {
        return [
            new OnlyTheYoung(),
            new Landslide(),
            new Watershed(),
        ];
    }

    public function getAllWithAlbum(): array
    {
        $allWithAlbum = [];

        foreach($this->getAllProjects() as $project) {
            if ($this->getAlbumForProject($project) !== null) {
                $allWithAlbum[] = $project;
            }
        }

        return $allWithAlbum;
    }

    public function getAlbumForProject(ReleaseProject $releaseProject): ?ReleaseItemAlbum
    {
        return array_filter(
            $releaseProject->getReleaseItems(),
            static fn (ReleaseItem $releaseItem) => $releaseItem instanceof ReleaseItemAlbum
        )[0] ?? null;
    }

    /**
     * @return ReleaseItemAlbum[]
     */
    public function getAllAlbums(ReleaseProject $projectOnTop = null): array
    {
        $projects = $projectOnTop ? [$projectOnTop] : [];

        foreach ($this->getAllProjects() as $project) {
            if ($projectOnTop === null || $project->getSlug() !== $projectOnTop->getSlug()) {
                $projects[] = $project;
            }
        }

        $albums = [];

        foreach($projects as $project) {
            $albums[] = $this->getAlbumForProject($project);
        }

        return array_filter($albums);
    }
}