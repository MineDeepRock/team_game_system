<?php


namespace team_game_system\pmmp\form;


use form_builder\models\simple_form_elements\SimpleFormButton;
use form_builder\models\SimpleForm;
use pocketmine\Player;
use team_game_system\model\Map;

class SpawnPointsGroupsForm extends SimpleForm
{
    public function __construct(Map $map) {

        $buttons = [];

        foreach ($map->getSpawnPointGroups() as $key => $group) {
            $buttons[] = new SimpleFormButton(
                $key,
                null,
                function (Player $player) use ($map, $group) {
                    $player->sendForm(new SpawnPointsGroupDetailForm($map, $group));
                }
            );
        }
        parent::__construct($map->getName(), "", $buttons);
    }

    function onClickCloseButton(Player $player): void {
        // TODO: Implement onClickCloseButton() method.
    }
}