<?php


namespace team_game_system\service;


use team_game_system\model\GameId;
use team_game_system\store\GameStore;

class FinishGameService
{
    static function execute(GameId $gameId): void {
        $game = GameStore::findById($gameId);
        $game->close();

        GameStore::delete($gameId);
    }
}