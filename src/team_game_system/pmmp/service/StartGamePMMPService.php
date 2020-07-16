<?php

namespace team_game_system\pmmp\service;


use team_game_system\model\GameId;
use team_game_system\pmmp\event\StartedGameEvent;

class StartGamePMMPService
{
    static function execute(GameId $gameId): void {
        $event = new StartedGameEvent($gameId);
        $event->call();
    }
}