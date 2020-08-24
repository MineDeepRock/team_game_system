<?php


namespace team_game_system\service;


use team_game_system\DataFolderPath;
use team_game_system\model\Map;

class RemoveMapService
{
    static function execute(Map $map): void {
        //TODO:使用中だったらキャンセル
        if (file_exists(DataFolderPath::$map . $map->getName() . ".json")) {
            unlink(DataFolderPath::$map . $map->getName() . ".json");
        }
    }
}