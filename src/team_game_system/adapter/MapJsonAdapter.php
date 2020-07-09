<?php

namespace team_game_system\adapter;


use pocketmine\math\Vector3;
use team_game_system\model\Map;
use team_game_system\model\SpawnPoint;
use team_game_system\model\TeamId;

class MapJsonAdapter
{
    /**
     * @param array $json
     * @param TeamId[] $teamIds
     * @return Map
     */
    static function decode(array $json, array $teamIds): Map {
        $spawnPoints = [];

        foreach ($json["spawn_point_groups"] as $index => $spawnPointGroup) {
            $teamId = $teamIds[$index];
            array_map(function ($spawnPoint) use ($teamId) {
                $spawnPoints[] = new SpawnPoint(new TeamId($teamId), new Vector3($spawnPoint["x"], $spawnPoint["y"], $spawnPoint["z"]));
            }, $spawnPointGroup);
        }

        return new Map($json["name"], $json["level_name"], $spawnPoints);
    }

    static function encode(Map $map): array {

        $teamIds = [];
        foreach ($map->getSpawnPoints() as $spawnPoint) {
            if (!in_array((string)$spawnPoint->getTeamId(), $teamIds)) {
                $teamIds[] = (string)$spawnPoint->getTeamId();
            }
        }

        $spawnPointGroups = [];
        foreach ($map->getSpawnPoints() as $spawnPoint) {
            $pos = $spawnPoint->getPosition();

            if (!array_key_exists(array_search((string)$spawnPoint->getTeamId(), $teamIds), $spawnPointGroups)) {
                $spawnPointGroups[array_search((string)$spawnPoint->getTeamId(), $teamIds)] = [];
            }

            $spawnPointGroups[array_search((string)$spawnPoint->getTeamId(), $teamIds)][] = [
                "x" => $pos->getX(),
                "y" => $pos->getY(),
                "z" => $pos->getZ(),
            ];
        }

        return [
            "name" => $map->getName(),
            "level_name" => $map->getLevelName(),
            "spawn_point_groups" => $spawnPointGroups
        ];
    }
}