<?php

namespace Nozell\Scoreboard\Factory;

use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use Nozell\Database\YamlDatabase;
use Nozell\Scoreboard\Main;
use Nozell\Scoreboard\Utils\VariableReplacer;

class ScoreboardFactory
{

    public static function createScoreboard(Player $player, string $worldName): void
    {
        $scoreboard = Main::getInstance()->getScoreboard();

        $title = self::getTitleForWorld($worldName);
        $lines = self::getLinesForWorld($worldName);

        $replacements = VariableReplacer::getReplacements($player, $worldName);

        $scoreboard->new($player, "Scoreboard", TextFormat::colorize(VariableReplacer::replaceVariables($title, $replacements)));

        $lines = VariableReplacer::replaceLines($lines, $replacements);

        $i = 0;
        foreach ($lines as $line) {
            if ($i < 15) {
                $i++;
                $scoreboard->setLine($player, $i, TextFormat::colorize($line));
            }
        }
    }

    private static function getTitleForWorld(string $worldName): string
    {
        return (new YamlDatabase(Main::getInstance()->getDataFolder() . "scoreboard.yml", true))->get($worldName, 'title') ?? 'Default Title';
    }

    private static function getLinesForWorld(string $worldName): array
    {
        return (new YamlDatabase(Main::getInstance()->getDataFolder() . "scoreboard.yml", true))->get($worldName, 'lines') ?? [];
    }
}
