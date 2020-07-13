<?php


namespace team_game_system\service;


use team_game_system\model\Map;
use team_game_system\model\SpawnPoint;
use team_game_system\store\MapsStore;

class AddSpawnPointService
{
    static function execute(Map $map, int $index, SpawnPoint $spawnPoint): void {
        $spawnPoints = $map->getSpawnPoints();
        $spawnPoints[$index][] = $spawnPoint;

        MapsStore::update(new Map($map->getName(), $map->getLevelName(), $spawnPoints));
    }
}