<?php


namespace team_game_system\service;


use team_game_system\adapter\MapJsonAdapter;
use team_game_system\DataFolderPath;
use team_game_system\model\Map;

class SelectMapService
{
    static function byName(string $name, array $teams): Map {
        $teamIds = array_map(function ($team) {
            return $team->getId();
        }, $teams);
        $mapsData = json_decode(file_get_contents(DataFolderPath::MAP . $name . ".json"), true);
        return MapJsonAdapter::decode($mapsData, $teamIds);
    }

    static function random(array $teams): Map {
        $maps = self::all($teams);

        return $maps[array_rand($maps)];
    }

    static function all(array $teams): array {
        $teamIds = array_map(function ($team) {
            return $team->getId();
        }, $teams);

        $maps = [];
        $dh = opendir(DataFolderPath::MAP);
        while (($fileName = readdir($dh)) !== false) {
            if (filetype(DataFolderPath::MAP . $fileName) === "file") {
                $data = json_decode(file_get_contents(DataFolderPath::MAP . $fileName), true);
                $maps[] = MapJsonAdapter::decode($data, $teamIds);
            }
        }

        closedir($dh);

        return $maps;
    }
}