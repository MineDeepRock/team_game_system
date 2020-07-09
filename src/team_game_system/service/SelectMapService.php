<?php


namespace team_game_system\service;


use team_game_system\adapter\MapJsonAdapter;
use team_game_system\DataFolderPath;
use team_game_system\model\Map;

class SelectMapService
{
    static function byName(string $name): Map {
        $mapsData = json_decode(file_get_contents(DataFolderPath::MAP . $name . ".json"), true);
        return MapJsonAdapter::decode($mapsData);
    }

    static function random(): Map {
        $maps = self::all();

        return $maps[array_rand($maps)];
    }

    static function all(): array {
        $maps = [];
        $dh = opendir(DataFolderPath::MAP);
        while (($fileName = readdir($dh)) !== false) {
            if (filetype(DataFolderPath::MAP . $fileName) === "file") {
                $data = json_decode(file_get_contents(DataFolderPath::MAP . $fileName), true);
                $maps[] = MapJsonAdapter::decode($data);
            }
        }

        closedir($dh);

        return $maps;
    }
}