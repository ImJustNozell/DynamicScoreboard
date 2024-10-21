<?php

namespace Nozell\Scoreboard\Api;

use pocketmine\player\Player as Pl;
use pocketmine\scheduler\Task;
use pocketmine\Server;
use Nozell\Scoreboard\Main;
use Nozell\Database\YamlDatabase;
use Nozell\Scoreboard\Factory\ScoreboardFactory;
use Nozell\Scoreboard\Factory\ReloadFactory;

class ScoreboardApi extends Task
{
    private YamlDatabase $database;

    public function __construct()
    {
        $this->database = new YamlDatabase(Main::getInstance()->getDataFolder() . "scoreboard.yml", true);
        $this->setHandler(Main::getInstance()->getScheduler()->scheduleRepeatingTask($this, 20));
    }

    public function onRun(): void
    {
        $this->updateScoreboard();
    }

    public function updateScoreboard(): void
    {
        foreach (Server::getInstance()->getOnlinePlayers() as $player) {
            if (!$player instanceof Pl) {
                return;
            }

            $worldName = $player->getWorld()->getFolderName();

            Main::getInstance()->getScoreboard()->remove($player);

            if ($this->database->sectionExists($worldName)) {
                ScoreboardFactory::createScoreboard($player, $worldName);
            }
        }
    }

    public function reload(): void
    {
        ReloadFactory::reloadMainPlugin();
    }
}
