<?php

namespace ChristelMusic\Releases;

use ChristelMusic\LocalUrl;
use ChristelMusic\SheetMusic;
use DateTimeImmutable;
use DateTimeZone;
use Money\Money;

class IntoTheLuminous implements ReleaseProject
{
    public function getTitle(): string
    {
        return "Into the Luminous";
    }

    public function getIntroTextAsHtml(): string
    {
        return <<<HTML
            <p><em>'Into the Luminous'</em> is Christel's third album and <em>'Dawn of Life'</em> is the first single of
            this album.</p>
            <p>This track is about the feeling of a new beginning, that moment when something starts to change, and the
            sense of hope for what lies ahead.</p>
            <p>Musically, it begins with an intimate piano foundation and gradually grows into a warm, expansive, 
            orchestral sound. I wanted the music to capture that feeling of moving from something small and uncertain
            into something full of possibility.</p>
            <p>In many ways, Dawn of Life also feels like the right piece to begin this new chapter with. And this is 
            just the beginning.</p>
            HTML;
    }

    public function getSlug(): string
    {
        return "into-the-luminous";
    }

    public function getHeaderImageUrl(): LocalUrl
    {
        return new LocalUrl("/assets/images/header_into_the_luminous.jpg");
    }

    public function getProjectImageUrl(): LocalUrl
    {
        return new LocalUrl("/assets/images/project_into_the_luminous.jpg");
    }

    public function getOgImageUrl(): LocalUrl
    {
        return new LocalUrl("/assets/images/into_the_luminous.jpg");
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
                    return "Dawn of Life";
                }

                public function getReleaseDate(): DateTimeImmutable
                {
                    return new DateTimeImmutable("2026-11-06 00:00:00", new DateTimeZone("Europe/Amsterdam"));
                }

                public function getImageUrl(): LocalUrl
                {
                    return new LocalUrl("/assets/images/dawn_of_life.jpg");
                }

                public function getPreSaveLink(): ?string
                {
                    return 'https://ditto.fm/dawn-of-life';
                }

                public function getStreamingInformation(): ReleaseStreamingInformation
                {
                    return new ReleaseStreamingInformation(
                        'https://open.spotify.com/track/5KwakifIWjQmUg1mg8YKqz',
                        'https://music.apple.com/au/song/dawn-of-life/6817512612',
                        'https://www.deezer.com/nl/track/4318319692',
                        'https://tidal.com/track/565598340',
                        'https://music.amazon.com/tracks/B0HLH28Z7X',
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
                    return "Dreams of the Rose Garden";
                }

                public function getReleaseDate(): DateTimeImmutable
                {
                    return new DateTimeImmutable("2026-12-04 00:00:00", new DateTimeZone("Europe/Amsterdam"));
                }

                public function getImageUrl(): LocalUrl
                {
                    return new LocalUrl("/assets/images/dreams_of_the_rose_garden.jpg");
                }

                public function getPreSaveLink(): ?string
                {
                    return 'https://ditto.fm/dreams-of-the-rose-garden';
                }

                public function getStreamingInformation(): ReleaseStreamingInformation
                {
                    return new ReleaseStreamingInformation(
                        'https://open.spotify.com/artist/29x4lHXIQ1GiDMf6N4RofZ', # TODO - is now linking to the artist page
                        null,
                        null,
                        null,
                        null,
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
            new class implements ReleaseItemAlbum {
                public function getTitle(): string
                {
                    return "Into the Luminous";
                }

                public function getReleaseDate(): DateTimeImmutable
                {
                    return new DateTimeImmutable("2027-01-08 00:00:00", new DateTimeZone("Europe/Amsterdam"));
                }

                public function getImageUrl(): LocalUrl
                {
                    return new LocalUrl("/assets/images/jewelcase_into_the_luminous.jpg");
                }

                public function getTracks(): array
                {
                    return [
                        'Dawn of Life',
                        'A Summer Ago',
                        'Alluring Deception',
                        'Beneath the Surface',
                        'Dreams of the Rose Garden',
                        'A Brighter Future',
                        'Havoc Within',
                        'This Moment Together',
                        'Unfold',
                        'Resonance',
                    ];
                }

                public function getPreSaveLink(): ?string
                {
                    return 'https://ditto.fm/into-the-luminous';
                }

                public function getStreamingInformation(): ReleaseStreamingInformation
                {
                    return new ReleaseStreamingInformation(
                        'https://open.spotify.com/artist/29x4lHXIQ1GiDMf6N4RofZ', // TODO - is now linking to the artist page
                        null,
                        null,
                        null,
                        null,
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
                    return new LocalUrl("/into_the_luminous_order"); // TODO - does not exist yet
                }

                public function getOrderPrice(): Money
                {
                    return Money::EUR(1000);
                }
            },
        ];
    }
}