<?php

namespace Nozell\Scoreboard\Api;

use pocketmine\player\Player as Pl;
use pocketmine\scheduler\Task;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use Nozell\Scoreboard\Main;
use Nozell\Database\YamlDatabase;

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

            $scoreboard = Main::getInstance()->getScoreboard();
            $worldName = $player->getWorld()->getFolderName();

            $scoreboard->remove($player);

            if ($this->database->sectionExists($worldName)) {
                $title = $this->getTitleForWorld($worldName);
                $lines = $this->getLinesForWorld($worldName);

                if (empty($lines)) return;
                $scoreboard->new($player, "Scoreboard", TextFormat::colorize($title));

                $replace = [
                    "{date}" => date('d/m/Y'),
                    "{tps}" => Server::getInstance()->getTicksPerSecond(),
                    "{world}" => $worldName,
                    "{player_name}" => $player->getName(),
                    "{player_ping}" => $player->getNetworkSession()->getPing() . "ms",
                    "{players_online}" => strval(count(Server::getInstance()->getOnlinePlayers()))
                ];

                $i = 0;
                foreach ($lines as $line) {
                    if ($i < 15) {
                        $i++;
                        $line = str_replace(array_keys($replace), array_values($replace), TextFormat::colorize($line));
                        $scoreboard->setLine($player, $i, $line);
                    }
                }
            }
        }
    }

    private function getTitleForWorld(string $worldName): string
    {
        return $this->database->get($worldName, 'title') ?? '';
    }

    private function getLinesForWorld(string $worldName): array
    {
        return $this->database->get($worldName, 'lines') ?? [];
    }

    public function reload(): void
    {
        $pluginManager = Server::getInstance()->getPluginManager();
        $plugin = $pluginManager->getPlugin("DinamicScoreboard");

        if ($plugin !== null) {
            $pluginManager->disablePlugin($plugin);
            $pluginManager->enablePlugin($plugin);
        }
    }
}
