<?php

namespace Nozell\Scoreboard\Factory;

use pocketmine\Server;
use pocketmine\plugin\Plugin;
use Nozell\Scoreboard\Main;

class ReloadFactory
{
    public static function reloadPlugin(Plugin $plugin): void
    {
        $pluginManager = Server::getInstance()->getPluginManager();

        if ($pluginManager->isPluginEnabled($plugin)) {
            $pluginManager->disablePlugin($plugin);

            $pluginManager->enablePlugin($plugin);
        }
    }

    public static function reloadMainPlugin(): void
    {
        self::reloadPlugin(Main::getInstance());
    }
}
