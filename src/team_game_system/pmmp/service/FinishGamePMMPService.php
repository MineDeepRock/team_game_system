<?php


namespace team_game_system\pmmp\service;


use team_game_system\model\GameId;
use team_game_system\pmmp\event\FinishedGameEvent;
use team_game_system\store\GameStore;
use team_game_system\store\PlayerDataStore;

class FinishGamePMMPService
{
    static function execute(GameId $gameId): void {
        $event = new FinishedGameEvent(GameStore::findById($gameId), PlayerDataStore::getGamePlayers($gameId));
        $event->call();
    }
}