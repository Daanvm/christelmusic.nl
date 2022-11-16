<?php

namespace ChristelMusic\Releases;

use ChristelMusic\LocalUrl;
use Money\Money;

interface ReleaseItemAlbum extends ReleaseItem
{
    /**
     * @return string[]
     */
    public function getTracks(): array;

    public function getOrderUrl(): LocalUrl;
    public function getOrderPrice(): Money;
}