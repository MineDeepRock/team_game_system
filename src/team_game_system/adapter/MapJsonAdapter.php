<?php

namespace team_game_system\adapter;


use pocketmine\math\Vector3;
use team_game_system\model\Map;
use team_game_system\model\SpawnPoint;
use team_game_system\model\SpawnPointsGroup;

class MapJsonAdapter
{
    /**
     * @param array $json
     * @return Map
     */
    static function decode(array $json): Map {
        $newSpawnPointsGroups = [];

        foreach ($json["spawn_point_groups"] as $index => $spawnPointGroup) {
            $newSpawnPoints = [];
            foreach ($spawnPointGroup as $spawnPoint) {
                $newSpawnPoints[] = new SpawnPoint(new Vector3($spawnPoint["x"], $spawnPoint["y"], $spawnPoint["z"]));
            }

            $newSpawnPointsGroups[$index] = new SpawnPointsGroup($newSpawnPoints);
        }

        return new Map($json["name"], $json["level_name"], $newSpawnPointsGroups);
    }

    static function encode(Map $map): array {
        $spawnPointGroupsAsJson = [];
        $index = 0;
        foreach ($map->getSpawnPointGroups() as $spawnPointGroup) {
            $spawnPointGroupsAsJson[$index] = [];

            foreach ($spawnPointGroup->getSpawnPoints() as $spawnPoint) {
                $pos = $spawnPoint->getPosition();

                $spawnPointGroupsAsJson[$index][] = [
                    "x" => $pos->getX(),
                    "y" => $pos->getY(),
                    "z" => $pos->getZ(),
                ];
            }
            $index++;
        }

        return [
            "name" => $map->getName(),
            "level_name" => $map->getLevelName(),
            "spawn_point_groups" => $spawnPointGroupsAsJson
        ];
    }
}