<?php


namespace team_game_system\service;


use team_game_system\model\Team;
use team_game_system\store\PlayerDataStore;

class SortTeamsByPlayersService
{
    static function execute(array $teams): array {
        usort($teams, function ($a, $b) {
            self::compare($a, $b);
        });

        return $teams;
    }

    static private function compare(Team $a, Team $b): int {
        $teamAPlayer = count(PlayerDataStore::getTeamPlayers($a->getId()));
        $teamBPlayer = count(PlayerDataStore::getTeamPlayers($b->getId()));

        if ($teamAPlayer === $teamBPlayer) {
            return 0;
        }
        return ($teamAPlayer < $teamBPlayer) ? -1 : 1;
    }
}