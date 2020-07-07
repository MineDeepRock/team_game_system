<?php


namespace team_game_system;


use team_game_system\model\Game;
use team_game_system\model\GameId;
use team_game_system\service\CreateGameService;

class TeamGameSystem
{
    static function createGame(Game $game): void {
        CreateGameService::execute($game);
    }

    static function startGame(GameId $gameId): void {
        StartGameService::execute($gameId);
    }
}