<?php

namespace team_game_system\adapter;


use pocketmine\math\Vector3;
use team_game_system\model\Map;
use team_game_system\model\SpawnPoint;
use team_game_system\model\TeamId;

class MapJsonAdapter
{
    static function decode(array $json): Map {
        $spawnPoints = [];

        foreach ($json["spawn_points"] as $id => $team_spawn_points) {
            array_map(function ($vector) use ($id) {
                $spawnPoints[] = new SpawnPoint(new TeamId($id), new Vector3($vector["x"], $vector["y"], $vector["z"]));
            }, $team_spawn_points);
        }

        return new Map($json["name"], $json["level_name"], $spawnPoints);
    }

    static function encode(Map $map): array {
        $json = [
            "name" => $map->getName(),
            "level_name" => $map->getLevelName(),
            "spawn_points" => []
        ];

        foreach ($map->getSpawnPoints() as $teamSpawnPoint) {
            /** @var SpawnPoint $spawnPoint */
            foreach ($teamSpawnPoint as $spawnPoint) {
                $pos = $spawnPoint->getPosition();
                $json["spawn_points"][strval($spawnPoint->getTeamId())][] = [
                    "x" => $pos->getX(),
                    "y" => $pos->getY(),
                    "z" => $pos->getZ(),
                ];
            }
        }

        return $json;
    }
}