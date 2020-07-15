<?php


namespace team_game_system\pmmp\form;


use form_builder\models\simple_form_elements\SimpleFormButton;
use form_builder\models\SimpleForm;
use pocketmine\Player;
use team_game_system\model\Map;

class MapDetailForm extends SimpleForm
{
    public function __construct(Map $map) {
        parent::__construct($map->getName(), "", [
            new SimpleFormButton(
                "名前の変更",
                null,
                function (Player $player) use ($map) {
                    //TODO:
                }
            ),
            new SimpleFormButton(
                "スポーン地点の設定",
                null,
                function (Player $player) use ($map) {
                }
            ),
            new SimpleFormButton(
                "削除",
                null,
                function (Player $player) use ($map) {
                }
            ),
        ]);
    }

    function onClickCloseButton(Player $player): void {
        // TODO: Implement onClickCloseButton() method.
    }
}