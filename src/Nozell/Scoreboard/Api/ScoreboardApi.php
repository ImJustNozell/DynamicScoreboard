<?php

namespace Nozell\Scoreboard\Api;

use Nozell\Scoreboard\Factory\ReloadFactory;
use Nozell\Scoreboard\Factory\ScoreboardFactory;
use Nozell\Scoreboard\Main;
use Nozell\Scoreboard\Session\SessionManager;
use pocketmine\player\Player;
use pocketmine\scheduler\Task;
use pocketmine\Server;

class ScoreboardApi extends Task
{
    public function __construct()
    {
        $main = Main::getInstance();
        $this->setHandler($main->getScheduler()->scheduleRepeatingTask($this, 20));
    }

    public function onRun(): void
    {
        $this->updateScoreboards();
    }

    public function updateScoreboards(): void
    {
        foreach (Server::getInstance()->getOnlinePlayers() as $player) {
            assert($player instanceof Player);
            $session = SessionManager::getSession($player);
            $scoreboardName = $session->getScoreboard();

            $worldName = $player->getWorld()->getFolderName();

            ScoreboardFactory::createScoreboard($player, $worldName, $scoreboardName);
        }
    }

    public function reload(): void
    {
        ReloadFactory::reloadMainPlugin();
    }
}
