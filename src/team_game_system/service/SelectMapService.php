<?php


namespace team_game_system\service;


use team_game_system\adapter\MapJsonAdapter;
use team_game_system\model\Map;

class SelectMapService
{
    const PATH = "./plugin_data/TeamGameSystem/";

    static function byName(string $name): Map {
        $mapsData = json_decode(file_get_contents(self::PATH . $name . ".json"), true);
        return MapJsonAdapter::decode($mapsData);
    }

    static function random(): Map {
        $maps = self::all();

        return $maps[array_rand($maps)];
    }

    static function all(): array {
        $maps = [];
        $dh = opendir(self::PATH);
        while (($fileName = readdir($dh)) !== false) {
            if (filetype(self::PATH . $fileName) === "file") {
                $data = json_decode(file_get_contents(self::PATH . $fileName), true);
                $maps[] = MapJsonAdapter::decode($data);
            }
        }

        closedir($dh);

        return $maps;
    }
}