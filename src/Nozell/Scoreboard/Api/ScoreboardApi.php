<?php

namespace Nozell\Scoreboard\Api;

use Nozell\Scoreboard\Factory\ScoreboardFactory;
use pocketmine\player\Player;
use pocketmine\scheduler\Task;
use pocketmine\Server;

class ScoreboardApi extends Task
{
    public function onRun(): void
    {
        $this->updateScoreboards();
    }

    public function updateScoreboards(): void
    {
        foreach (Server::getInstance()->getOnlinePlayers() as $player) {
            if (!$player instanceof Player) {
                return;
            }

            $worldName = $player->getWorld()->getFolderName();

            ScoreboardFactory::createScoreboard($player, $worldName);
        }
    }
}
