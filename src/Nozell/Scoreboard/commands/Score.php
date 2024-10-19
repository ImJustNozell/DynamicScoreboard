<?php

namespace Nozell\Scoreboard\commands;

use Nozell\Scoreboard\menus\Scoreboard;
use Nozell\Scoreboard\menus\ScoreboardCreate;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class Score extends Command
{

  public function __construct()
  {
    parent::__construct("score", "Manage scoreboard", "/score <create|edit>");
    $this->setPermission("score.command.use");
  }

  public function execute(CommandSender $sender, string $label, array $args): bool
  {
    if (!$sender instanceof Player) {
      $sender->sendMessage("Solo los jugadores pueden usar este comando");
      return true;
    }

    switch (strtolower($args[0])) {
      case "create":
        if (!$sender->hasPermission("score.command.use")) {
          $sender->sendMessage("§cNo tienes permiso para agregar scoreboards.");
          return true;
        }
        $score = new ScoreboardCreate($sender);


        break;

      case "edit":
        if (!$sender->hasPermission("score.command.use")) {
          $sender->sendMessage("§cNo tienes permiso para eliminar scoreboards.");
        }
        $score = new Scoreboard($sender);
        break;
    }
    return true;
  }
}
