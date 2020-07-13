<?php


namespace team_game_system\service;


use team_game_system\data_model\PlayerData;
use team_game_system\model\GameId;
use team_game_system\store\GameStore;
use team_game_system\store\PlayerDataStore;

class FinishGameService
{
    static function execute(GameId $gameId): void {
        $game = GameStore::findById($gameId);
        $game->close();

        GameStore::delete($gameId);
        $playersData = PlayerDataStore::getGamePlayers($gameId);
        foreach ($playersData as $playerData) {
            PlayerDataStore::update(new PlayerData($playerData->getName(), null, null));
        }
    }
}