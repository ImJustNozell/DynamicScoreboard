<?php

namespace Nozell\Scoreboard\menus;

use pocketmine\player\Player;
use Vecnavium\FormsUI\CustomForm;
use Nozell\Database\DatabaseFactory;
use Nozell\Scoreboard\Main;

class Scoreboard extends CustomForm
{
    private Main $main;
    public function __construct(Player $player)
    {
        $main = $this->getMain();
        $dbType = $main->getDatabaseType();
        $database = DatabaseFactory::create($main->getDatabaseFile(), $dbType);

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

            (new EditScoreboard($player, $selectedWorld));
        });

        $this->setTitle("Seleccionar Mundo para Editar Scoreboard");
        $this->addDropdown("Selecciona el Mundo", $worldNames);

        $player->sendForm($this);
    }

    public function  getMain(): Main
    {

        return $this->main;
    }
}
