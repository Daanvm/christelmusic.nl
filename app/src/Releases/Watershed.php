<?php

namespace ChristelMusic\Releases;

use ChristelMusic\LocalUrl;
use ChristelMusic\SheetMusic;
use DateTimeImmutable;
use DateTimeZone;
use Money\Money;

class Watershed implements ReleaseProject
{
    public function getTitle(): string
    {
        return "Watershed";
    }

    public function getIntroTextAsHtml(): string
    {
        return <<<HTML
            <p>In 2021 Christel released her first album 'Watershed'. It is a collection of solo piano songs that reflect
            different moods. Whether it's peaceful, uplifting, energetic, dramatic or epic, it's always passionate. "I
            get really excited when I notice that my mood changes when I play a certain piece."</p>
            HTML;
    }

    public function getSlug(): string
    {
        return "watershed";
    }

    public function getHeaderImageUrl(): LocalUrl
    {
        return new LocalUrl("/assets/images/header_watershed.jpg");
    }

    public function getProjectImageUrl(): LocalUrl
    {
        return new LocalUrl("/assets/images/project_watershed.jpg");
    }

    public function getOgImageUrl(): LocalUrl
    {
        return new LocalUrl("/assets/images/watershed.jpg");
    }

    /**
     * @return ReleaseItem[]
     */
    public function getReleaseItems(): array
    {
        return [
            new class implements ReleaseItemAlbum {
                public function getTitle(): string
                {
                    return "Watershed";
                }

                public function getReleaseDate(): DateTimeImmutable
                {
                    return new DateTimeImmutable("2021-05-21 00:00:00", new DateTimeZone("Europe/Amsterdam"));
                }

                public function getImageUrl(): LocalUrl
                {
                    return new LocalUrl("/assets/images/jewelcase_watershed.jpg");
                }

                public function getTracks(): array
                {
                    return [
                        'Watershed',
                        'A Glimpse of Hope',
                        'On the Run',
                        'Memories',
                        'Chased by Shadows',
                        'Daydream',
                        'Mischievous Exploration',
                        'The Vigor of the Ocean',
                    ];
                }

                public function getPreSaveLink(): ?string
                {
                    return null;
                }

                public function getStreamingInformation(): ReleaseStreamingInformation
                {
                    return new ReleaseStreamingInformation(
                        'https://open.spotify.com/album/5SpgF9L5ek58qnjjP9dbIm',
                        'https://music.apple.com/nl/album/watershed/1566134580',
                        'https://deezer.page.link/3R7ZbF9kZg7i1kTp6',
                        'https://tidal.com/browse/album/183080996',
                        'https://music.amazon.com/albums/B09476LFPX',
                    );
                }

                /**
                 * @return SheetMusic[]
                 */
                public function getSheetMusics(): array
                {
                    return [];
                }

                public function getOrderUrl(): LocalUrl
                {
                    return new LocalUrl("/watershed_order");
                }

                public function getOrderPrice(): Money
                {
                    return Money::EUR(800);
                }
            },
            new class implements ReleaseItemSingle {
                public function getTitle(): string
                {
                    return "Daydream";
                }

                public function getReleaseDate(): DateTimeImmutable
                {
                    return new DateTimeImmutable("2021-04-30 00:00:00", new DateTimeZone("Europe/Amsterdam"));
                }

                public function getImageUrl(): LocalUrl
                {
                    return new LocalUrl("/assets/images/daydream.jpg");
                }

                public function getPreSaveLink(): ?string
                {
                    return null;
                }

                public function getStreamingInformation(): ReleaseStreamingInformation
                {
                    return new ReleaseStreamingInformation(
                        'https://open.spotify.com/track/1qgANWl98NuQ5JwtJnH6eO',
                        'https://music.apple.com/nl/album/daydream-single/1563040219',
                        'https://deezer.page.link/48hCyySKP9ZRhcbe8',
                        'https://tidal.com/browse/track/180599573',
                        'https://music.amazon.com/albums/B092JR86Q7',
                    );
                }

                /**
                 * @return SheetMusic[]
                 */
                public function getSheetMusics(): array
                {
                    return [];
                }
            },
            new class implements ReleaseItemSingle {
                public function getTitle(): string
                {
                    return "Watershed";
                }

                public function getReleaseDate(): DateTimeImmutable
                {
                    return new DateTimeImmutable("2021-04-11 00:00:00", new DateTimeZone("Europe/Amsterdam"));
                }

                public function getImageUrl(): LocalUrl
                {
                    return new LocalUrl("/assets/images/watershed.jpg");
                }

                public function getPreSaveLink(): ?string
                {
                    return null;
                }

                public function getStreamingInformation(): ReleaseStreamingInformation
                {
                    return new ReleaseStreamingInformation(
                        'https://open.spotify.com/track/7o2vFMbCdAsS1kw30gItDn',
                        'https://music.apple.com/nl/album/watershed-single/1560090229',
                        'https://deezer.page.link/nG5d7zfAaZDwzUP76',
                        'https://tidal.com/track/178478594',
                        'https://music.amazon.com/albums/B0917G2C7V',
                    );
                }

                /**
                 * @return SheetMusic[]
                 */
                public function getSheetMusics(): array
                {
                    return [];
                }
            },
        ];
    }
}