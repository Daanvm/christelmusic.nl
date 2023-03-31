<?php

namespace ChristelMusic\Releases;

use ChristelMusic\LocalUrl;

interface ReleaseProject
{
    public function getTitle(): string;
    public function getIntroTextAsHtml(): string;
    public function getSlug(): string;
    public function getHeaderImageUrl(): LocalUrl;
    public function getProjectImageUrl(): LocalUrl;
    public function getOgImageUrl(): LocalUrl;


    /**
     * @return ReleaseItem[]
     */
    public function getReleaseItems(): array;
}