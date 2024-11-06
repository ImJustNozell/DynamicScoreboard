<?php

namespace Nozell\Scoreboard\Factory;

use Nozell\Scoreboard\Main;
use pocketmine\plugin\Plugin;
use pocketmine\Server;

class ReloadFactory
{
    private static Main $main;

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
        self::reloadPlugin(self::getMain());
    }

    public static function  getMain(): Main
    {

        return self::$main;
    }
}
