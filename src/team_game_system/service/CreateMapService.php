<?php


namespace team_game_system\service;


use team_game_system\adapter\MapJsonAdapter;
use team_game_system\DataFolderPath;
use team_game_system\model\Map;

class CreateMapService
{
    static function execute(Map $map): bool {
        if (file_exists(DataFolderPath::MAP . $map->getName() . ".json")) return false;

        file_put_contents(DataFolderPath::MAP . $map->getName() . ".json", json_encode(MapJsonAdapter::encode($map)));
        return true;
    }
}