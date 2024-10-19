<?php

declare(strict_types=1);

namespace Nozell\Scoreboard;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use Nozell\Scoreboard\scoreboard\Scoreboard;
use Nozell\Scoreboard\Api\ScoreboardApi;
use Nozell\Scoreboard\Api\ScoreTagApi;
use Nozell\Scoreboard\commands\Score;
use pocketmine\utils\SingletonTrait;

class Main extends PluginBase
{
  use SingletonTrait;

  private Scoreboard $scoreboard;

  public function onEnable(): void
  {
    self::setInstance($this);

    $this->saveDefaultConfig();
    $this->saveConfigurations(
      "/Session/Scoreboard.yml",
      "/Session/Score.yml"
    );

    $this->scoreboard = new Scoreboard();
    new ScoreboardApi();

    $this->getServer()->getCommandMap()->register("score", new Score());

    $this->getLogger()->info(TextFormat::GREEN . "Plugin DynamicScoreboard ha sido habilitado correctamente");
  }

  private function saveConfigurations(string ...$configs): void
  {
    foreach ($configs as $config) {
      $this->saveResource($config);
    }
  }

  public function getScoreboard(): Scoreboard
  {
    return $this->scoreboard;
  }

  public function onDisable(): void
  {
    $this->getLogger()->info(TextFormat::GREEN . "Plugin DynamicScoreboard ha sido deshabilitado correctamente");
  }
}
