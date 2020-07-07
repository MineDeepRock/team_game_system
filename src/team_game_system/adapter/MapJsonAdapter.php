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

        return new Map($json["name"], $spawnPoints);
    }
}