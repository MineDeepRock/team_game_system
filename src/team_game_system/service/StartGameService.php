<?php

namespace team_game_system\service;


use team_game_system\model\GameId;
use team_game_system\store\GameStore;

class StartGameService
{
    static function execute(GameId $gameId):void {
        GameStore::findById($gameId)->start();
    }
}