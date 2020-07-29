<?php


namespace team_game_system\service;


use team_game_system\model\Map;
use team_game_system\store\MapsStore;

class RemoveSpawnPointsGroupService
{
    static function execute(Map $map, int $groupIndex): void {
        $spawnPointsGroups = $map->getSpawnPointGroups();
        unset($spawnPointsGroups[$groupIndex]);

        MapsStore::update(new Map($map->getName(), $map->getLevelName(), $spawnPointsGroups));
    }
}