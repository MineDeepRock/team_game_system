<?php


namespace team_game_system\service;


use Exception;
use team_game_system\model\Map;

class AdaptMapToTeamsService
{
    static function execute(Map $map, array $teams): Map {
        if (count($map->getSpawnPoints()) !== count($teams)) {
            throw new Exception("マップに登録されているスポーン地点グループと、チームの数が一致しませんでした");
        }

        $newSpawnPoints = [];
        $teamIds = array_map(function ($team) { return $team->getId(); }, $teams);

        foreach ($map->getSpawnPoints() as $index => $spawnPointGroup) {
            $newSpawnPoints[$index] = [];
            foreach ($spawnPointGroup as $spawnPoint) {
                $newSpawnPoints[$index][strval($teamIds[$index])] = $spawnPoint;
            }
        }

        return new Map($map->getName(), $map->getLevelName(), $newSpawnPoints);
    }
}