<?php

namespace Nozell\Scoreboard\menus;

use pocketmine\player\Player;
use pocketmine\Server;
use Vecnavium\FormsUI\CustomForm;
use Nozell\Database\DatabaseFactory;
use Nozell\Scoreboard\Main;
use Nozell\Scoreboard\Api\ScoreboardApi;

class ScoreboardCreate extends CustomForm
{
    private array $worldNames;
    private Main $main;

    public function __construct(Player $player)
    {
        $main = $this->getMain();

        $dbType = $main->getDatabaseType();

        $database = DatabaseFactory::create($main->getDatabaseFile(), $dbType);

        $worldManager = Server::getInstance()->getWorldManager();
        $this->worldNames = [];
        foreach ($worldManager->getWorlds() as $world) {
            $worldName = $world->getFolderName();

            if (!$database->sectionExists($worldName)) {
                $this->worldNames[] = $worldName;
            }
        }

        if (empty($this->worldNames)) {
            $player->sendMessage("§cTodos los mundos ya tienen un Scoreboard asignado.");
            return;
        }

        parent::__construct([$this, 'onSubmit']);

        $this->setTitle("Crear Scoreboard");
        $this->addDropdown("Selecciona el Mundo", $this->worldNames);
        $this->addInput("Título", "Ingresa el título del scoreboard");

        for ($i = 1; $i <= 15; $i++) {
            $this->addToggle("Activar Línea $i", false);
            $this->addInput("Línea $i", "Ingresa el texto de la línea $i");
        }

        $player->sendForm($this);
    }

    public function onSubmit(Player $player, ?array $data): void
    {
        if ($data === null) {
            return;
        }

        $selectedWorldIndex = $data[0];
        $worldName = $this->worldNames[$selectedWorldIndex];
        $title = $data[1];

        $lines = [];
        for ($i = 0; $i < 15; $i++) {
            if ($data[2 + $i * 2]) {
                $lines[] = $data[3 + $i * 2];
            }
        }

        $main = $this->getMain();
        $dbType = $main->getDatabaseType();
        $database = DatabaseFactory::create($main->getDatabaseFile(), $dbType);

        $database->set($worldName, "title", $title);
        $database->set($worldName, "lines", $lines);

        $score = new ScoreboardApi();
        $score->reload();

        $player->sendMessage("§aScoreboard creado para el mundo '$worldName' exitosamente.");
    }

    public function  getMain(): Main
    {

        return $this->main;
    }
}
