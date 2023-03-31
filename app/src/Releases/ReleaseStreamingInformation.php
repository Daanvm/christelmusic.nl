<?php

namespace ChristelMusic\Releases;

class ReleaseStreamingInformation implements \Countable
{
    public function __construct(
        readonly string $spotifyUrl,
        readonly ?string $appleMusicUrl,
        readonly ?string $deezerUrl,
        readonly ?string $tidalUrl,
        readonly ?string $amazonUrl,
    ) {}

    public function count(): int
    {
        $count = 1;

        if ($this->appleMusicUrl !== null) {
            $count++;
        }
        if ($this->deezerUrl !== null) {
            $count++;
        }
        if ($this->tidalUrl !== null) {
            $count++;
        }
        if ($this->amazonUrl !== null) {
            $count++;
        }

        return $count;
    }
}