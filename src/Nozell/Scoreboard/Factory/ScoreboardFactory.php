<?php

namespace Nozell\Scoreboard\Factory;

use Nozell\Database\DatabaseFactory;
use Nozell\PlaceholderAPI\PlaceholderAPI;
use Nozell\Scoreboard\Main;
use pocketmine\player\Player;

class ScoreboardFactory
{
    private static array $customScoreboards = [];

    public static function createCustomScoreboard(string $name, string $title, array $lines, int $priority): void
    {
        self::$customScoreboards[] = [
            'name' => $name,
            'title' => $title,
            'lines' => $lines,
            'priority' => $priority
        ];

        usort(self::$customScoreboards, function ($a, $b) {
            return $a['priority'] <=> $b['priority'];
        });
    }

    public static function removeCustomScoreboard(string $name): void
    {
        self::$customScoreboards = array_filter(self::$customScoreboards, function ($scoreboard) use ($name) {
            return $scoreboard['name'] !== $name;
        });

        self::$customScoreboards = array_values(self::$customScoreboards);
    }

    public static function resetScoreboard(): void
    {
        self::$customScoreboards = [];
    }

    public static function getActualScoreboard(Player $player, string $worldName): array
    {
        if (!empty(self::$customScoreboards)) {
            $highestPriorityScoreboard = self::$customScoreboards[0];
            return [
                'title' => $highestPriorityScoreboard['title'],
                'lines' => $highestPriorityScoreboard['lines']
            ];
        }

        $title = self::getTitleForWorld($worldName);
        $lines = self::getLinesForWorld($worldName);

        return [
            'title' => $title,
            'lines' => $lines
        ];
    }

    public static function createScoreboard(Player $player, string $worldName): void
    {
        $scoreboard = Main::getInstance()->getScoreboard();

        $actualScoreboard = self::getActualScoreboard($player, $worldName);
        $title = $actualScoreboard['title'];
        $lines = $actualScoreboard['lines'];

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
