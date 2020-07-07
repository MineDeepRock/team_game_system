<?php


namespace team_game_system\service;


use team_game_system\data_model\PlayerData;
use team_game_system\model\GameId;
use team_game_system\model\TeamId;
use team_game_system\store\GameStore;
use team_game_system\store\PlayerDataStore;

class JoinGameService
{
    static function execute(string $name, GameId $gameId, ?TeamId $teamId): void {
        if ($teamId === null) {
            $game = GameStore::findById($gameId);
            $teamId = SortTeamsByPlayersService::execute($game->getTeams())[0];
            PlayerDataStore::update(new PlayerData($name, $gameId, $teamId));
        } else {
            PlayerDataStore::update(new PlayerData($name, $gameId, $teamId));
        }
    }
}