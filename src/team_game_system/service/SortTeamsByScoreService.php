<?php


namespace team_game_system\service;


use team_game_system\model\Team;

//大きい順
class SortTeamsByScoreService
{
    /**
     * @param array $teams
     * @return Team[]
     */
    static function execute(array $teams): array {
        usort($teams, function ($a, $b): int {
            return self::compare($a, $b);
        });

        return $teams;
    }

    static private function compare(Team $a, Team $b): int {

        if ($a->getScore()->getValue() === $b->getScore()->getValue()) {
            return 0;
        }
        return ($a->getScore()->getValue() > $b->getScore()->getValue()) ? -1 : 1;
    }
}