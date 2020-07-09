<?php


namespace team_game_system\pmmp\form;


use form_builder\models\CustomForm;
use pocketmine\Player;

class MapCreateForm extends CustomForm
{

    public function __construct() {
        parent::__construct("マップ作成", []);
    }

    function onSubmit(Player $player): void {
        // TODO: Implement onSubmit() method.
    }

    function onClickCloseButton(Player $player): void {
        // TODO: Implement onClickCloseButton() method.
    }
}