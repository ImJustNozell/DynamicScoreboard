<?php

namespace Nozell\Scoreboard\Factory;

use Nozell\Database\DatabaseFactory;
use Nozell\Scoreboard\Utils\VariableReplacer;
use Nozell\Scoreboard\Main;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class ScoreboardFactory
{
    private static Main $main;

    public static function createScoreboard(Player $player, string $worldName): void
    {
        $scoreboard = self::getMain()->getScoreboard();

        $title = self::getTitleForWorld($worldName);
        $lines = self::getLinesForWorld($worldName);

        $replacements = VariableReplacer::getReplacements($player, $worldName);

        $scoreboard->new($player, 'Scoreboard', TextFormat::colorize(VariableReplacer::replaceVariables($title, $replacements)));

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
        $main = self::getMain();
        $database = DatabaseFactory::create($main->getDatabaseFile(), $main->getDatabaseType());

        return $database->get($worldName, 'title') ?? 'Default Title';
    }

    private static function getLinesForWorld(string $worldName): array
    {
        $main = self::getMain();
        $database = DatabaseFactory::create($main->getDatabaseFile(), $main->getDatabaseType());

        return $database->get($worldName, 'lines') ?? [];
    }

    public static function  getMain(): Main
    {

        return self::$main;
    }
}
