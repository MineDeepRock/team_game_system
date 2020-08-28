<?php


namespace team_game_system\service;


use team_game_system\model\Map;
use team_game_system\model\SpawnPoint;
use team_game_system\model\SpawnPointsGroup;
use team_game_system\store\MapsStore;

class RemoveSpawnPointService
{
    static function execute(Map $map, int $groupIndex, SpawnPoint $targetSpawnPoint): void {
        $spawnPointsGroups = $map->getSpawnPointGroups();

        foreach ($spawnPointsGroups as $index => $spawnPointGroup) {
            if ($index === $groupIndex) {
                $newSpawnPoints = [];
                foreach ($spawnPointGroup->getSpawnPoints() as $spawnPoint) {
                    if (!$spawnPoint->equals($targetSpawnPoint)) $newSpawnPoints[] = $spawnPoint;
                }
                $spawnPointsGroups[$index] = new SpawnPointsGroup($newSpawnPoints);
            }
        }

        MapsStore::update(new Map($map->getName(), $map->getLevelName(), $spawnPointsGroups));
    }
}