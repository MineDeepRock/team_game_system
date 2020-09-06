<?php


namespace team_game_system\service;


use team_game_system\model\GameId;
use team_game_system\model\Team;
use team_game_system\model\TeamId;
use team_game_system\store\GameStore;

class FindTeamService
{
    static function execute(GameId $gameId, TeamId $teamId): ?Team {
        $game = GameStore::findById($gameId);
        if ($game === null) return null;
        foreach ($game->getTeams() as $team) {
            if ($team->getId()->equals($teamId)) return $team;
        }

        return null;
    }
}