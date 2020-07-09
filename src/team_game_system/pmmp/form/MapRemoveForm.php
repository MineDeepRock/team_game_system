<?php


namespace team_game_system\pmmp\form;


use form_builder\models\modal_form_elements\ModalFormButton;
use form_builder\models\ModalForm;
use pocketmine\Player;
use team_game_system\model\Map;

class MapRemoveForm extends ModalForm
{

    public function __construct(Map $map) {
        parent::__construct($map->getName(),
            "削除しますか？",
            new ModalFormButton("はい"),
            new ModalFormButton("いいえ"));
    }

    function onClickCloseButton(Player $player): void {
        // TODO: Implement onClickCloseButton() method.
    }

    public function onClickButton1(Player $player): void {
        // TODO: Implement onClickButton1() method.
    }

    public function onClickButton2(Player $player): void {
        // TODO: Implement onClickButton2() method.
    }
}