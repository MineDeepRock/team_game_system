<?php


namespace team_game_system\store;


use team_game_system\adapter\MapJsonAdapter;
use team_game_system\DataFolderPath;
use team_game_system\model\Map;

class MapsStore
{
    static function findByName(string $name): ?Map {
        if (!file_exists(DataFolderPath::MAP . $name . ".json")) return null;

        $mapsData = json_decode(file_get_contents(DataFolderPath::MAP . $name . ".json"), true);
        return MapJsonAdapter::decode($mapsData);
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

    static function create(Map $map): void {
        file_put_contents(DataFolderPath::MAP . $map->getName() . ".json", json_encode(MapJsonAdapter::encode($map)));
    }

    static function update(Map $map): void {
        file_put_contents(DataFolderPath::MAP . $map->getName() . ".json", json_encode(MapJsonAdapter::encode($map)));
    }
}