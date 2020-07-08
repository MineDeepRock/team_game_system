<?php


namespace team_game_system\service;


use team_game_system\data_model\PlayerData;
use team_game_system\store\PlayerDataStore;

class QuitGameService
{
    static function execute(string $name) {
        PlayerDataStore::update(new PlayerData($name, null, null));
    }
}