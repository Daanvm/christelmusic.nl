<?php declare(strict_types=1);

namespace ChristelMusic;

use Parable\Framework\Application;

class Boot
{
    /**
     * The key is the time slot the plugins will be registered and executed in,
     * the values the class names.
     *
     * @return string[][]
     */
    public static function getPluginsToRegister(): array
    {
        return [
            Application::PLUGIN_BEFORE_BOOT => [
                RouterPlugin::class,
            ],
            Application::PLUGIN_AFTER_BOOT => [
            ],
        ];
    }
}
