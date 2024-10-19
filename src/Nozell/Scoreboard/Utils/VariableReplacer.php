<?php

namespace Nozell\Scoreboard\Utils;

use pocketmine\player\Player;
use pocketmine\Server;

class VariableReplacer
{
    public static function getReplacements(Player $player, string $worldName): array
    {
        return [
            "{date}" => date('d/m/Y'),
            "{tps}" => Server::getInstance()->getTicksPerSecond(),
            "{world}" => $worldName,
            "{player_name}" => $player->getName(),
            "{player_ping}" => $player->getNetworkSession()->getPing() . "ms",
            "{players_online}" => strval(count(Server::getInstance()->getOnlinePlayers()))
        ];
    }

    public static function replaceVariables(string $text, array $replacements): string
    {
        return str_replace(array_keys($replacements), array_values($replacements), $text);
    }

    public static function replaceLines(array $lines, array $replacements): array
    {
        foreach ($lines as &$line) {
            $line = self::replaceVariables($line, $replacements);
        }
        return $lines;
    }
}
