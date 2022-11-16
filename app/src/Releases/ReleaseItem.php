<?php

namespace ChristelMusic\Releases;

use ChristelMusic\LocalUrl;
use ChristelMusic\SheetMusic;
use DateTimeImmutable;

interface ReleaseItem
{
    public function getTitle(): string;
    public function getReleaseDate(): DateTimeImmutable;
    public function getImageUrl(): LocalUrl;
    public function getPreSaveLink(): ?string;
    public function getStreamingInformation(): ReleaseStreamingInformation;

    /**
     * @return SheetMusic[]
     */
    public function getSheetMusics(): array;
}