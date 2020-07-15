<?php


namespace team_game_system\pmmp\slot_menu;


use pocketmine\item\ItemIds;
use pocketmine\Player;
use slot_menu_system\models\SlotMenu;
use slot_menu_system\models\SlotMenuElement;
use team_game_system\model\Map;
use team_game_system\model\SpawnPoint;
use team_game_system\pmmp\form\SpawnPointsGroupDetailForm;
use team_game_system\service\RemoveSpawnPointService;

class SpawnPointSlotMenu extends SlotMenu
{
    public function __construct(Map $map, int $groupIndex, SpawnPoint $spawnPoint) {
        parent::__construct([
            new SlotMenuElement(ItemIds::TNT, "削除", 0, function (Player $player) use ($map, $groupIndex, $spawnPoint) {
                RemoveSpawnPointService::execute($map, $groupIndex, $spawnPoint);
                $player->sendForm(new SpawnPointsGroupDetailForm($map, $map->getSpawnPointGroups()[$groupIndex]));
            }),
            new SlotMenuElement(ItemIds::HOPPER_BLOCK, "戻る", 1, function (Player $player) use ($map, $groupIndex) {
                $player->sendForm(new SpawnPointsGroupDetailForm($map, $map->getSpawnPointGroups()[$groupIndex]));
            }),
        ]);
    }
}