<?php


namespace team_game_system\service;


use team_game_system\model\Map;
use team_game_system\model\SpawnPoint;
use team_game_system\store\MapsStore;

class RemoveSpawnPointService
{
    static function execute(Map $map, int $index, SpawnPoint $targetSpawnPoint): void {
        $spawnPointGroups = $map->getSpawnPoints();

        //$spawnPointGroupsのkeyが文字列な場合(adaptされている)もあるから$iが必要
        $i = 0;
        foreach ($spawnPointGroups as $index1 => $spawnPointGroup) {
            if ($i === $index) {
                foreach ($spawnPointGroup as $index2 => $spawnPoint) {
                    if ($spawnPoint->equals($targetSpawnPoint)) unset($spawnPointGroups[$index1][$index2]);
                }
            }
        }

        MapsStore::update(new Map($map->getName(), $map->getLevelName(), $spawnPointGroups));
    }
}