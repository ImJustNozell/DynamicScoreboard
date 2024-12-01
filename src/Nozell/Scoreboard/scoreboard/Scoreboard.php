<?php

namespace Nozell\Scoreboard\scoreboard;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\network\mcpe\protocol\{
    RemoveObjectivePacket,
    SetDisplayObjectivePacket,
    SetScorePacket
};
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;
use pocketmine\utils\SingletonTrait;

class Scoreboard
{
    use SingletonTrait;
    private $scoreboards = [];

    public function new(Player $player, string $objectiveName, string $displayName): void
    {
        if (isset($this->scoreboards[$player->getName()])) {
            $this->remove($player);
        }

        $pk = new SetDisplayObjectivePacket();
        $pk->displaySlot = "sidebar";
        $pk->objectiveName = $objectiveName;
        $pk->displayName = $displayName;
        $pk->criteriaName = "dummy";
        $pk->sortOrder = 0;

        $player->getNetworkSession()->sendDataPacket($pk);
        $this->scoreboards[$player->getName()] = $objectiveName;
    }

    public function remove(Player $player): void
    {
        if (isset($this->scoreboards[$player->getName()])) {
            $objectiveName = $this->getObjectiveName($player);
            $pk = new RemoveObjectivePacket();
            $pk->objectiveName = $objectiveName;

            $player->getNetworkSession()->sendDataPacket($pk);
            unset($this->scoreboards[$player->getName()]);
        }
    }

    public function setLine(Player $player, int $score, string $message): void
    {
        if (!isset($this->scoreboards[$player->getName()])) {
            Server::getInstance()->getLogger()->info("The player \"" . $player->getName() . "\" does not have a scoreboard.");
            return;
        }

        if ($score > 15 || $score < 1) {
            Server::getInstance()->getLogger()->info("Error, you exceeded the limit of parameters 1-15. Scoreboard out of range");
            return;
        }

        $objectiveName = $this->getObjectiveName($player);

        $entry = new ScorePacketEntry();
        $entry->objectiveName = $objectiveName;
        $entry->type = $entry::TYPE_FAKE_PLAYER;
        $entry->customName = $message;
        $entry->score = $score;
        $entry->scoreboardId = $score;

        $pk = new SetScorePacket();
        $pk->type = $pk::TYPE_CHANGE;
        $pk->entries[] = $entry;

        $player->getNetworkSession()->sendDataPacket($pk);
    }

    public function addLine(Player $player, int $score, string $message): void
    {
        $this->setLine($player, $score, $message);
    }

    public function getObjectiveName(Player $player): ?string
    {
        return $this->scoreboards[$player->getName()] ?? null;
    }
}
