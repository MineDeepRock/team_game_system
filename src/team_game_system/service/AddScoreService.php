<?php


namespace team_game_system\service;


use team_game_system\model\GameId;
use team_game_system\model\Score;
use team_game_system\model\TeamId;
use team_game_system\store\GameStore;

class AddScoreService
{
    static function execute(GameId $gameId, TeamId $teamId, Score $score): void {
        $game = GameStore::findById($gameId);
        $team = array_filter($game->getTeams(), function ($team) use ($teamId) {
            return $team->getId()->equals($teamId);
        })[0];

        $team->add($score);
    }
}