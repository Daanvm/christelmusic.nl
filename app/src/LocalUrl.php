<?php

namespace ChristelMusic;

use Webmozart\Assert\Assert;

class LocalUrl
{
    public function __construct(readonly string $localUrl)
    {
        Assert::startsWith($localUrl, '/');
        Assert::notEndsWith($localUrl, ".php");
    }

    public function __toString(): string
    {
        return $this->localUrl;
    }
}