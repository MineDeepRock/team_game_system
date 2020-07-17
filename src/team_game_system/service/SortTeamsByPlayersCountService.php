<?php


namespace team_game_system\service;


use team_game_system\model\Team;
use team_game_system\store\PlayerDataStore;

class SortTeamsByPlayersCountService
{
    static function execute(array $teams): array {
        usort($teams, function ($a, $b): int {
            return self::compare($a, $b);
        });

        return $teams;
    }

    static private function compare(Team $a, Team $b): int {
        $teamAPlayersCount = count(PlayerDataStore::getTeamPlayers($a->getId()));
        $teamBPlayersCount = count(PlayerDataStore::getTeamPlayers($b->getId()));

        if ($teamAPlayersCount === $teamBPlayersCount) {
            return 0;
        }
        return ($teamAPlayersCount < $teamBPlayersCount) ? -1 : 1;
    }
}