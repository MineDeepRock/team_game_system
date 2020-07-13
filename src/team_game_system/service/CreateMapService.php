<?php


namespace team_game_system\service;


use team_game_system\model\Map;
use team_game_system\store\MapsStore;

class CreateMapService
{
    static function execute(Map $map): bool {
        if (MapsStore::findByName($map->getName())) return false;

        MapsStore::create($map);
        return true;
    }
}