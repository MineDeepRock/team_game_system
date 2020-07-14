<?php


namespace team_game_system\service;


use Exception;
use team_game_system\model\Map;
use team_game_system\model\SpawnPointsGroup;

class AdaptMapToTeamsService
{
    static function execute(Map $map, array $teams): Map {
        if (count($map->getSpawnPointGroups()) !== count($teams)) {
            throw new Exception("マップに登録されているスポーン地点グループと、チームの数が一致しませんでした");
        }

        $newSpawnPointsGroups = [];
        $teamIds = array_map(function ($team) {
            return $team->getId();
        }, $teams);

        foreach ($map->getSpawnPointGroups() as $index => $spawnPointGroup) {
            $newSpawnPointsGroups[$index] = new SpawnPointsGroup($spawnPointGroup->getSpawnPoints(), $teamIds[$index]);
        }

        return new Map($map->getName(), $map->getLevelName(), $newSpawnPointsGroups);
    }
}