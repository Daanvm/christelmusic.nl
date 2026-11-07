<?php declare(strict_types=1);

if (getenv('SKIP_LOAD_DOTENV_FILE') === false) {
    $dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
    $dotenv->load();
}
