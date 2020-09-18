<?php


namespace team_game_system\pmmp\form;


use form_builder\models\simple_form_elements\SimpleFormButton;
use form_builder\models\SimpleForm;
use pocketmine\Player;
use slot_menu_system\SlotMenuSystem;
use team_game_system\model\Map;
use team_game_system\model\SpawnPoint;
use team_game_system\model\SpawnPointsGroup;
use team_game_system\pmmp\slot_menu\AddSpawnPointSlotMenu;
use team_game_system\pmmp\slot_menu\SpawnPointSlotMenu;
use team_game_system\store\MapsStore;

class SpawnPointsGroupDetailForm extends SimpleForm
{
    private $mapName;

    public function __construct(Map $map, int $groupIndex, SpawnPointsGroup $group) {
        $this->mapName = $map->getName();

        $buttons = [
            new SimpleFormButton(
                "スポーン地点を追加",
                null,
                function (Player $player) use ($map, $groupIndex, $group) {
                    SlotMenuSystem::send($player, new AddSpawnPointSlotMenu($map, $groupIndex));
                }
            )
        ];

        foreach ($group->getSpawnPoints() as $spawnPoint) {
            $pos = $spawnPoint->getPosition();
            $text = "x:" . intval($pos->getX()) . ",y:" . intval($pos->getY()) . ",z:" . intval($pos->getZ());
            $buttons[] = new SimpleFormButton(
                $text,
                null,
                function (Player $player) use ($map, $groupIndex, $spawnPoint) {
                    SlotMenuSystem::send($player, new SpawnPointSlotMenu($map, $groupIndex, $spawnPoint));
                }
            );
        }

        $buttons[] = new SimpleFormButton(
            "グループを削除",
            null,
            function (Player $player) use ($map, $groupIndex) {
                $player->sendForm(new MapRemoveSpawnPointsGroupForm($map, $groupIndex));
            }
        );

        parent::__construct($map->getName(), "", $buttons);
    }

    function onClickCloseButton(Player $player): void {
        $player->sendForm(new SpawnPointsGroupsForm(MapsStore::findByName($this->mapName)));
    }
}