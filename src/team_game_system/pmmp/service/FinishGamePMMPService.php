<?php


namespace team_game_system\pmmp\service;


use team_game_system\model\Game;
use team_game_system\pmmp\event\FinishedGameEvent;

class FinishGamePMMPService
{
    static function execute(Game $game, array $playersData): void {
        $event = new FinishedGameEvent($game, $playersData);
        $event->call();
    }
}