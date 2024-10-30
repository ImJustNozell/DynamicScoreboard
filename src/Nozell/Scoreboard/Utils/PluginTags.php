<?php

namespace Nozell\Scoreboard\Utils;

use pocketmine\player\Player;

class PluginTags
{
    public static function addVariables(Player $player, array $replacements): array
    {
        if (class_exists(\onebone\economyapi\EconomyAPI::class)) {
            $economyApi = \onebone\economyapi\EconomyAPI::getInstance();
            if ($economyApi !== null) {
                $money = $economyApi->myMoney($player);
                $replacements["{money}"] = "$" . number_format($money, 2);
            }
        }

        return $replacements;
    }
}
