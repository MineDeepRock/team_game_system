<?php


namespace team_game_system\pmmp\form;


use form_builder\models\simple_form_elements\SimpleFormButton;
use form_builder\models\SimpleForm;
use pocketmine\Player;
use slot_menu_system\SlotMenuSystem;
use team_game_system\model\Map;
use team_game_system\model\SpawnPointsGroup;
use team_game_system\pmmp\slot_menu\SpawnPointSlotMenu;

class SpawnPointsGroupDetailForm extends SimpleForm
{
    public function __construct(Map $map, SpawnPointsGroup $group) {
        $buttons = [];

        foreach ($group->getSpawnPoints() as $key => $spawnPoint) {
            $pos = $spawnPoint->getPosition();
            $buttons[] = new SimpleFormButton(
                "{$pos->getX()},{$pos->getY()},{$pos->getZ()}",
                null,
                function (Player $player) use ($map) {
                    SlotMenuSystem::send($player,new SpawnPointSlotMenu());
                }
            );
        }

        parent::__construct($map->getName(), "", []);
    }

    function onClickCloseButton(Player $player): void {
        // TODO: Implement onClickCloseButton() method.
    }
}