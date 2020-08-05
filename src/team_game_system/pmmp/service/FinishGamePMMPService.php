<?php


namespace team_game_system\pmmp\service;


use team_game_system\model\Game;
use team_game_system\pmmp\event\FinishedGameEvent;
use team_game_system\service\SortTeamsByScoreService;

class FinishGamePMMPService
{
    static function execute(Game $game, array $playersData): void {
        $teamsSortedByScore = SortTeamsByScoreService::execute($game->getTeams());
        if (count($teamsSortedByScore) >= 2) {
            if ($teamsSortedByScore[0]->getScore()->getValue() === $teamsSortedByScore[1]->getScore()->getValue()) {
                $event = new FinishedGameEvent($game, $playersData, null);
                $event->call();
                return;
            }
        }


        $event = new FinishedGameEvent($game, $playersData, $teamsSortedByScore[0]);
        $event->call();
    }
}