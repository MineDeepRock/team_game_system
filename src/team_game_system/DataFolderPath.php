<?php


namespace team_game_system;


class DataFolderPath
{
    static $map;

    static function init(string $path) {
        self::$map = $path . "maps/";

        if (!file_exists(self::$map)) mkdir(self::$map);
    }
}