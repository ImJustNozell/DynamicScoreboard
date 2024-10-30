<?php

declare(strict_types=1);

namespace Nozell\Scoreboard;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use Nozell\Scoreboard\scoreboard\Scoreboard;
use Nozell\Scoreboard\Api\ScoreboardApi;
use Nozell\Scoreboard\commands\Score;
use pocketmine\Server;
use pocketmine\utils\SingletonTrait;

class Main extends PluginBase
{
  use SingletonTrait;

  private Scoreboard $scoreboard;

  public function onEnable(): void
  {
    self::setInstance($this);
    $startTime = microtime(true);

    $this->saveDefaultConfig();

    $dbType = $this->getDatabaseType();
    $dbFile = $this->getDatabaseFile();

    Server::getInstance()->getLogger()->info("Tipo de base de datos: $dbType");
    Server::getInstance()->getLogger()->info("Archivo de base de datos: $dbFile");

    $this->scoreboard = new Scoreboard();
    new ScoreboardApi();

    Server::getInstance()->getCommandMap()->register("score", new Score());

    Server::getInstance()->getLogger()->debug("DynScore enabling");

    $endTime = microtime(true);
    $executionTime = ($endTime - $startTime);

    if ($executionTime < 1) {
      $execution = $executionTime * 1_000;
      Server::getInstance()
        ->getLogger()
        ->info("DynScore enabled in " . round($execution, 2) . " ms.");
    } else {
      Server::getInstance()
        ->getLogger()
        ->info("DynScore enabled in " . round($executionTime, 2) . " s.");
    }
  }

  public function getDatabaseType(): string
  {
    return $this->getConfig()->get("database")["type"] ?? "yaml";
  }

  public function getDatabaseFile(): string
  {
    $dataFolder = $this->getDataFolder();
    $dbType = strtolower($this->getDatabaseType());

    switch ($dbType) {
      case 'json':
        return $dataFolder . "scoreboard.json";
      case 'sqlite':
        return $dataFolder . "scoreboard.db";
      case 'yaml':
      default:
        return $dataFolder . "scoreboard.yml";
    }
  }

  public function getScoreboard(): Scoreboard
  {
    return $this->scoreboard;
  }

  public function onDisable(): void
  {
    $this->getLogger()->info(TextFormat::GREEN . "DynScore ha sido deshabilitado correctamente");
  }
}
