<?php

namespace team_game_system\pmmp\form;


use form_builder\models\simple_form_elements\SimpleFormButton;
use form_builder\models\SimpleForm;
use pocketmine\Player;

class MapMenuForm extends SimpleForm
{
    public function __construct() {
        parent::__construct("MapMenu", "", [
            new SimpleFormButton("Create",
                null,
                function (Player $player) {
                    $player->sendForm(new MapCreateForm());
                }
            ),
            new SimpleFormButton("List",
                null,
                function (Player $player) {
                    $player->sendForm(new MapListForm());
                }
            )
        ]);
    }

    function onClickCloseButton(Player $player): void {
        // TODO: Implement onClickCloseButton() method.
    }
}