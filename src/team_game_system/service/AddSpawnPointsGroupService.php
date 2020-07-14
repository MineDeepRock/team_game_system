<?php


namespace team_game_system\service;


use team_game_system\model\Map;
use team_game_system\model\SpawnPointsGroup;
use team_game_system\store\MapsStore;

class AddSpawnPointsGroupService
{
    static function execute(Map $map): void {
        $spawnPointsGroups = $map->getSpawnPointGroups();
        $spawnPointsGroups[] = new SpawnPointsGroup([]);

        MapsStore::update(new Map($map->getName(),$map->getLevelName(),$spawnPointsGroups));
    }
}