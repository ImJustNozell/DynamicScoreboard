<?php

namespace Nozell\Scoreboard\Listener;

use Nozell\Scoreboard\Session\SessionManager;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;

class ScoreboardListener implements Listener
{
    public function onPlayerJoin(PlayerJoinEvent $event): void
    {
        $player = $event->getPlayer();
        
        SessionManager::createSession($player);
    }

    public function onPlayerQuit(PlayerQuitEvent $event): void
    {
        $player = $event->getPlayer();

        SessionManager::removeSession($player);
    }
}
