<?php


namespace team_game_system\service;


use pocketmine\Player;
use team_game_system\data_model\PlayerData;
use team_game_system\model\GameId;
use team_game_system\model\TeamId;
use team_game_system\store\GameStore;
use team_game_system\store\PlayerDataStore;

class JoinGameService
{
    static function execute(string $playerName, GameId $gameId, ?TeamId $teamId): bool {
        $game = GameStore::findById($gameId);
        if ($game->isClosed()) return false;

        $playersCount = count(PlayerDataStore::getGamePlayers($gameId));
        if ($game->getMaxPlayersCount() !== null) {
            if ($game->getMaxPlayersCount() === $playersCount) return false;
        }

        if ($teamId === null) {
            $teamId = SortTeamsByPlayersService::execute($game->getTeams())[0]->getId();
            PlayerDataStore::update(new PlayerData($playerName, $gameId, $teamId));
        } else {
            PlayerDataStore::update(new PlayerData($playerName, $gameId, $teamId));
        }

        return true;
    }
}