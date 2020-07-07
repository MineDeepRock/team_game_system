<?php


namespace team_game_system;


use pocketmine\Player;
use team_game_system\model\Game;
use team_game_system\model\GameId;
use team_game_system\model\TeamId;
use team_game_system\service\CreateGameService;
use team_game_system\service\JoinGameService;
use team_game_system\service\StartGameService;
use team_game_system\store\GameStore;

class TeamGameSystem
{
    static function createGame(Game $game): void {
        CreateGameService::execute($game);
    }

    static function startGame(GameId $gameId): void {
        StartGameService::execute($gameId);
    }

    static function joinGame(Player $player, GameId $gameId, ?TeamId $teamId): void {
        JoinGameService::execute($player, $gameId, $teamId);
        $game = GameStore::findById($gameId);

        if ($game->isStarted()) {
            //TODO : 途中参加
        }
    }
}