<?php

namespace Nozell\Scoreboard\Factory;

use Nozell\Database\DatabaseFactory;
use Nozell\PlaceholderAPI\PlaceholderAPI;
use Nozell\Scoreboard\Main;
use Nozell\Scoreboard\Session\SessionManager;
use pocketmine\player\Player;

class ScoreboardFactory
{
    private static array $customScoreboards = [];

    public static function createCustomScoreboard(string $name, string $title, array $lines, int $priority): void
    {
        self::$customScoreboards[$name] = [
            'title' => $title,
            'lines' => $lines,
            'priority' => $priority
        ];
    }

    public static function removeCustomScoreboard(string $name): void
    {
        if (isset(self::$customScoreboards[$name])) {
            unset(self::$customScoreboards[$name]);
        }
    }

    public static function createScoreboard(Player $player, string $worldName): void
    {
        $main = Main::getInstance();
        $scoreboard = $main->getScoreboard();

        if ($scoreboard === null) {
            $main->getLogger()->error("Scoreboard instance is null. Check your Main class setup.");
            return;
        }

        $session = SessionManager::getSession($player);
        $scoreboardName = $session->getScoreboard();

        $title = '';
        $lines = [];

        if ($scoreboardName === 'default') {
            $title = self::getTitleForWorld($worldName);
            $lines = self::getLinesForWorld($worldName);
        } elseif (isset(self::$customScoreboards[$scoreboardName])) {
            $actualScoreboard = self::$customScoreboards[$scoreboardName];
            $title = $actualScoreboard['title'];
            $lines = $actualScoreboard['lines'];
        } else {
            $title = self::getTitleForWorld($worldName);
            $lines = self::getLinesForWorld($worldName);
        }

        $filteredLines = PlaceholderAPI::getRegistry()->filterTags($lines, $player);

        $scoreboard->new($player, 'Scoreboard', $title);

        $i = 0;
        foreach ($filteredLines as $line) {
            if ($i < 15) {
                $i++;
                $scoreboard->setLine($player, $i, PlaceholderAPI::getRegistry()->parsePlaceholders($line, $player));
            }
        }
    }

    private static function getTitleForWorld(string $worldName): string
    {
        $main = Main::getInstance();
        $database = DatabaseFactory::create($main->getDatabaseFile(), $main->getDatabaseType());

        return $database->get($worldName, 'title') ?? 'Default Title';
    }

    private static function getLinesForWorld(string $worldName): array
    {
        $main = Main::getInstance();
        $database = DatabaseFactory::create($main->getDatabaseFile(), $main->getDatabaseType());

        return $database->get($worldName, 'lines') ?? [];
    }
}
