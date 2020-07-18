<?php

namespace team_game_system\service;


use team_game_system\model\Game;
use team_game_system\store\GameStore;

class RegisterGameService
{
    static function execute(Game $game):void{
        GameStore::add($game);
    }
}