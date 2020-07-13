<?php


namespace team_game_system\pmmp\form;


use form_builder\models\simple_form_elements\SimpleFormButton;
use form_builder\models\SimpleForm;
use pocketmine\Player;
use team_game_system\model\Map;
use team_game_system\store\MapsStore;

class MapListForm extends SimpleForm
{

    public function __construct() {
        parent::__construct("マップ一覧", "", array_map(
            function (Map $map) {
                return new SimpleFormButton(
                    $map->getName(),
                    null,
                    function (Player $player) use ($map) {
                        $player->sendForm(new MapDetailForm($map));
                    }
                );
            },
            MapsStore::all()));
    }

    function onClickCloseButton(Player $player): void {
        // TODO: Implement onClickCloseButton() method.
    }
}