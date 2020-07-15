<?php


namespace team_game_system\pmmp\slot_menu;


use pocketmine\item\ItemIds;
use pocketmine\Player;
use slot_menu_system\models\SlotMenu;
use slot_menu_system\models\SlotMenuElement;
use team_game_system\model\Map;
use team_game_system\model\SpawnPoint;
use team_game_system\pmmp\form\SpawnPointsGroupDetailForm;
use team_game_system\service\AddSpawnPointService;
use team_game_system\store\MapsStore;

class AddSpawnPointSlotMenu extends SlotMenu
{
    public function __construct(Map $map, int $groupIndex, SpawnPoint $spawnPoint) {
        parent::__construct([
            new SlotMenuElement(ItemIds::EMERALD, "追加", 0, function (Player $player) use ($map, $groupIndex, $spawnPoint) {
                $player->getInventory()->setContents([]);
                AddSpawnPointService::execute($map, $groupIndex, $spawnPoint);
                $updatedMap = MapsStore::findByName($map->getName());
                $player->sendForm(new SpawnPointsGroupDetailForm($updatedMap, $groupIndex, $updatedMap->getSpawnPointGroups()[$groupIndex]));
            }),
            new SlotMenuElement(ItemIds::HOPPER_BLOCK, "戻る", 1, function (Player $player) use ($map, $groupIndex) {
                $player->getInventory()->setContents([]);
                $updatedMap = MapsStore::findByName($map->getName());
                $player->sendForm(new SpawnPointsGroupDetailForm($updatedMap, $groupIndex, $updatedMap->getSpawnPointGroups()[$groupIndex]));
            }),
        ]);
    }
}