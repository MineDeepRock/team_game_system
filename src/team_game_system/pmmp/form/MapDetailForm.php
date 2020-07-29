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
                "スポーン地点",
                null,
                function (Player $player) use ($map) {
                    $player->sendForm(new SpawnPointsGroupsForm($map));
                }
            ),
            new SimpleFormButton(
                "マップを削除",
                null,
                function (Player $player) use ($map) {
                    $player->sendForm(new MapRemoveForm($map));
                }
            ),
        ]);
    }

    function onClickCloseButton(Player $player): void {
        // TODO: Implement onClickCloseButton() method.
    }
}