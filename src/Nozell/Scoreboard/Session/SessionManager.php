<?php

namespace Nozell\Scoreboard\Session;

use pocketmine\player\Player;

class SessionManager
{
    private static array $sessions = [];

    public static function createSession(Player $player): void
    {
        $xuid = $player->getXuid();

        if (!isset(self::$sessions[$xuid])) {
            self::$sessions[$xuid] = new Session($xuid);
        }
    }

    public static function getSession(Player $player): Session
    {
        $xuid = $player->getName();

        if (!isset(self::$sessions[$xuid])) {
            self::$sessions[$xuid] = new Session($xuid);
        }

        return self::$sessions[$xuid];
    }
    public static function removeSession(Player $player): void
    {
        $xuid = $player->getXuid();
        unset(self::$sessions[$xuid]);
    }

    public static function getAllSessions(): array
    {
        return self::$sessions;
    }

    

    public static function clearAllSessions(): void
    {
        self::$sessions = [];
    }
}
