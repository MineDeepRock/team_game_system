<?php


namespace team_game_system\service;


use team_game_system\data_model\PlayerData;
use team_game_system\model\GameId;
use team_game_system\store\GameStore;
use team_game_system\store\GameTimerTaskHandlersStore;
use team_game_system\store\PlayerDataStore;

class FinishGameService
{
    static function execute(GameId $gameId): void {
        $game = GameStore::findById($gameId);
        $game->close();

        $timerHandler = GameTimerTaskHandlersStore::findByGameId($gameId);
        $timerHandler->cancel();

        GameTimerTaskHandlersStore::delete($gameId);

        GameStore::delete($gameId);
        $playersData = PlayerDataStore::getGamePlayers($gameId);
        foreach ($playersData as $playerData) {
            PlayerDataStore::update(new PlayerData($playerData->getName(), null, null));
        }
    }
}