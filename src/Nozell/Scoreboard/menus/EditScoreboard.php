<?php

namespace Nozell\Scoreboard\menus;

use pocketmine\player\Player;
use Vecnavium\FormsUI\CustomForm;
use Nozell\Database\DatabaseFactory;
use Nozell\Scoreboard\Main;
use Nozell\Scoreboard\Api\ScoreboardApi;

class EditScoreboard extends CustomForm
{
    private Main $main;
    public function __construct(Player $player, string $worldName)
    {
        $main = $this->getMain();
        $dbType = $main->getDatabaseType();
        $database = DatabaseFactory::create($main->getDatabaseFile(), $dbType);

        if (!$database->sectionExists($worldName)) {
            $player->sendMessage("§cEl mundo seleccionado no tiene un Scoreboard asignado.");
            return;
        }

        $currentTitle = $database->get($worldName, "title") ?? "Título predeterminado";
        $currentLines = $database->get($worldName, "lines") ?? [];

        parent::__construct(function (Player $player, ?array $data, $main) use ($worldName, $currentLines, $dbType) {
            if ($data === null) {
                return;
            }

            $title = $data[0];
            $lines = [];

            for ($i = 0; $i < 15; $i++) {
                if ($data[1 + $i * 2]) {
                    $lines[] = $data[2 + $i * 2];
                }
            }

            $database = DatabaseFactory::create($main->getDatabaseFile(), $dbType);
            $database->set($worldName, "title", $title);
            $database->set($worldName, "lines", $lines);

            $score = new ScoreboardApi();
            $score->reload();

            $player->sendMessage("§aScoreboard del mundo '{$worldName}' actualizado exitosamente.");
        });

        $this->setTitle("Editar Scoreboard: $worldName");
        $this->addInput("Título", "Ingresa el título del scoreboard", $currentTitle);

        for ($i = 1; $i <= 15; $i++) {
            $lineText = $currentLines[$i - 1] ?? "";
            $this->addToggle("Activar Línea $i", $lineText !== "");
            $this->addInput("Línea $i", "Ingresa el texto de la línea $i", $lineText);
        }

        $player->sendForm($this);
    }

    public function  getMain(): Main
    {

        return $this->main;
    }
}
