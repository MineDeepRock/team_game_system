<?php


namespace team_game_system\service;


use team_game_system\model\GameId;
use team_game_system\model\Score;
use team_game_system\model\TeamId;
use team_game_system\pmmp\service\FinishGamePMMPService;
use team_game_system\store\GameStore;
use team_game_system\store\PlayerDataStore;

class AddScoreService
{
    static function execute(GameId $gameId, TeamId $teamId, Score $score): void {
        $game = GameStore::findById($gameId);
        $targetTeam = null;

        foreach ($game->getTeams() as $team) {
            if($team->getId()->equals($teamId)){
                $targetTeam = $team;
            }
        }

        $targetTeam->addScore($score);

        if ($game->getMaxScore() === null) return;
        if($targetTeam->getScore()->getValue() >= $game->getMaxScore()->getValue()) {
            $playersData = PlayerDataStore::getGamePlayers($gameId);
            $game = GameStore::findById($gameId);

            FinishGameService::execute($gameId);
            FinishGamePMMPService::execute($game, $playersData);
        }
    }
}