<?php


namespace team_game_system\pmmp\form;


use form_builder\models\CustomForm;
use pocketmine\Player;
use team_game_system\model\Map;

class MapDetailForm extends CustomForm
{

    public function __construct(Map $map) {
        parent::__construct($map->getName(), []);
    }

    function onSubmit(Player $player): void {
        // TODO: Implement onSubmit() method.
    }

    function onClickCloseButton(Player $player): void {
        // TODO: Implement onClickCloseButton() method.
    }
}