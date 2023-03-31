<?php

declare(strict_types=1);

namespace ChristelMusic\Releases;

use ChristelMusic\LocalUrl;
use ChristelMusic\SheetMusic;
use DateTimeImmutable;
use DateTimeZone;

final class OnlyTheYoung implements ReleaseProject
{
    public function getTitle(): string
    {
        return "Only the Young";
    }

    public function getSlug(): string
    {
        return "onlytheyoung";
    }

    public function getHeaderImageUrl(): LocalUrl
    {
        // I don't have a header image for Only the Young yet.
        return new LocalUrl('/assets/images/header_landslide.jpg');
    }

    public function getProjectImageUrl(): LocalUrl
    {
        return new LocalUrl('/assets/images/project_onlytheyoung.jpg');
    }

    public function getOgImageUrl(): LocalUrl
    {
        return new LocalUrl('/assets/images/onlytheyoung.jpg');
    }

    /**
     * @return ReleaseItem[]
     */
    public function getReleaseItems(): array
    {
        return [
            new class implements ReleaseItemSingle {
                public function getTitle(): string
                {
                    return "Only the Young";
                }

                public function getReleaseDate(): DateTimeImmutable
                {
                    return new DateTimeImmutable("2023-03-31 00:00:00", new DateTimeZone("Europe/Amsterdam"));
                }

                public function getImageUrl(): LocalUrl
                {
                    return new LocalUrl('/assets/images/onlytheyoung.jpg');
                }

                public function getPreSaveLink(): ?string
                {
                    return null;
                }

                public function getStreamingInformation(): ReleaseStreamingInformation
                {
                    return new ReleaseStreamingInformation(
                        'https://open.spotify.com/track/0sWBMNDovWl9wMu6QuzwJB',
                        null,
                        'https://deezer.page.link/QvdyWUUX6jSbXgXG6',
                        null,
                        null
                    );
                }

                /**
                 * @return SheetMusic[]
                 */
                public function getSheetMusics(): array
                {
                    return [];
                }
            }
        ];
    }
}