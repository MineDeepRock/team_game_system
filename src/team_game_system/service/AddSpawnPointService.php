<?php


namespace team_game_system\service;


use team_game_system\model\Map;
use team_game_system\model\SpawnPoint;
use team_game_system\model\SpawnPointsGroup;
use team_game_system\store\MapsStore;

class AddSpawnPointService
{
    static function execute(Map $map, int $index, SpawnPoint $spawnPoint): void {
        $spawnPointsGroups = $map->getSpawnPointGroups();
        $spawnPoints = $spawnPointsGroups[$index]->getSpawnPoints();
        $spawnPoints[] = $spawnPoint;
        $spawnPointsGroups[$index] = new SpawnPointsGroup($spawnPoints);

        MapsStore::update(new Map($map->getName(), $map->getLevelName(), $spawnPointsGroups));
    }
}