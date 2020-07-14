<?php


namespace team_game_system\service;


use team_game_system\model\Map;
use team_game_system\model\SpawnPoint;
use team_game_system\model\SpawnPointsGroup;
use team_game_system\store\MapsStore;

class RemoveSpawnPointService
{
    static function execute(Map $map, int $index, SpawnPoint $targetSpawnPoint): void {
        $spawnPointsGroups = $map->getSpawnPointGroups();

        $i = 0;
        foreach ($spawnPointsGroups as $index1 => $spawnPointGroup) {
            if ($i === $index) {
                $newSpawnPoints = [];
                foreach ($spawnPointGroup->getSpawnPoints() as $spawnPoint) {
                    if (!$spawnPoint->equals($targetSpawnPoint)) $newSpawnPoints[] = $spawnPoint;
                }
                $spawnPointsGroups[$index1] = new SpawnPointsGroup($newSpawnPoints);
            }
        }

        MapsStore::update(new Map($map->getName(), $map->getLevelName(), $spawnPointsGroups));
    }
}