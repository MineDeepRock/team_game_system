<?php

namespace team_game_system\adapter;


use pocketmine\math\Vector3;
use team_game_system\model\Map;
use team_game_system\model\SpawnPoint;

class MapJsonAdapter
{
    /**
     * @param array $json
     * @return Map
     */
    static function decode(array $json): Map {
        $spawnPoints = [];

        foreach ($json["spawn_point_groups"] as $index => $spawnPointGroup) {
            $spawnPoints[$index] = [];
            foreach ($spawnPointGroup as $spawnPoint) {
                $spawnPoints[$index][] = new SpawnPoint(new Vector3($spawnPoint["x"], $spawnPoint["y"], $spawnPoint["z"]));
            }
        }

        return new Map($json["name"], $json["level_name"], $spawnPoints);
    }

    static function encode(Map $map): array {
        $spawnPointGroups = [];
        $index = 0;
        foreach ($map->getSpawnPoints() as $spawnPointGroup) {
            $spawnPointGroups[$index] = [];

            foreach ($spawnPointGroup as $spawnPoint) {
                $pos = $spawnPoint->getPosition();

                $spawnPointGroups[$index][] = [
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
            "spawn_point_groups" => $spawnPointGroups
        ];
    }
}