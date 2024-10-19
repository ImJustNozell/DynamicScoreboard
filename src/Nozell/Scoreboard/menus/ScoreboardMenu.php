<?php

namespace Nozell\Scoreboard\menus;

use pocketmine\player\Player;
use Vecnavium\FormsUI\CustomForm;
use Nozell\Database\YamlDatabase;
use Nozell\Scoreboard\Main;

class Scoreboard extends CustomForm
{

    public function __construct(Player $player)
    {
        $database = new YamlDatabase(Main::getInstance()->getDataFolder() . "scoreboard.yml", true);

        $worldNames = $database->getAllSections();

        if (empty($worldNames)) {
            $player->sendMessage("§cNo hay mundos con Scoreboard asignados.");
            return;
        }

        parent::__construct(function (Player $player, ?array $data) use ($worldNames) {
            if ($data === null || !isset($data[0])) {
                return;
            }

            $selectedWorld = $worldNames[$data[0]];
            (new EditScoreboard($player, $selectedWorld))->sendToPlayer($player);
        });

        $this->setTitle("Seleccionar Mundo para Editar Scoreboard");
        $this->addDropdown("Selecciona el Mundo", $worldNames);
        $player->sendForm($this);
    }
}
