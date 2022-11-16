<?php

namespace ChristelMusic\Releases;

class ReleaseStreamingInformation
{
    public function __construct(
        readonly string $spotifyUrl,
        readonly string $appleMusicUrl,
        readonly string $deezerUrl,
        readonly ?string $tidalUrl,
        readonly string $amazonUrl,
    ) {}
}