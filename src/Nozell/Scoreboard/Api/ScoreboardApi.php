<?php

namespace Nozell\Scoreboard\Api;

use Nozell\Database\DatabaseFactory;
use Nozell\Scoreboard\Factory\ReloadFactory;
use Nozell\Scoreboard\Factory\ScoreboardFactory;
use Nozell\Scoreboard\Main;
use pocketmine\player\Player as Pl;
use pocketmine\scheduler\Task;
use pocketmine\Server;

class ScoreboardApi extends Task
{
    private $database;

    public function __construct()
    {
        $main = Main::getInstance();
        $this->database = DatabaseFactory::create($main->getDatabaseFile(), $main->getDatabaseType());

        $this->setHandler($main->getScheduler()->scheduleRepeatingTask($this, 20));
    }

    public function onRun(): void
    {
        $this->updateScoreboard();
    }

    public function updateScoreboard(): void
    {
        foreach (Server::getInstance()->getOnlinePlayers() as $player) {
            if (!$player instanceof Pl)
                return;

            $worldName = $player->getWorld()->getFolderName();

            if (!$this->database->sectionExists($worldName))
                return;

            ScoreboardFactory::createScoreboard($player, $worldName);
        }
    }

    public function reload(): void
    {
        ReloadFactory::reloadMainPlugin();
    }
}
