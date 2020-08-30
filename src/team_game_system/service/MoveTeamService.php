<?php


namespace team_game_system\service;


use team_game_system\data_model\PlayerData;
use team_game_system\model\GameId;
use team_game_system\model\Team;
use team_game_system\model\TeamId;
use team_game_system\store\GameStore;
use team_game_system\store\PlayerDataStore;
use team_game_system\TeamGameSystem;

class MoveTeamService
{
    static function execute(string $playerName, GameId $gameId, ?TeamId $teamId, bool $force = false): bool {

        $playerData = PlayerDataStore::findByName($playerName);
        //参加していなかったらダメ
        if ($playerData->getGameId() === null) return false;
        //すでに参加しているチームだったらダメ
        if ($playerData->getTeamId() === $teamId) return false;

        $game = GameStore::findById($gameId);
        if ($game->isClosed()) return false;

        //強制 TODO:JoinGameServiceとコードがダブっている
        if ($force) {
            PlayerDataStore::update(new PlayerData($playerName, $gameId, $teamId));
            return true;
        } else {
            $teams = SortTeamsByPlayersCountService::execute($game->getTeams());
            if (count($teams) <= 1) {
                PlayerDataStore::update(new PlayerData($playerName, $gameId, $teamId));
                return true;
            }

            //人数差が２人以上なら
            /** @var Team $popularTeam */
            $popularTeam = end($teams);
            $popularTeamMembers = TeamGameSystem::getTeamPlayersData($popularTeam->getId());

            /** @var Team $notPopularTeam */
            $notPopularTeam = $teams[0];
            $notPopularTeamMembers = TeamGameSystem::getTeamPlayersData($notPopularTeam->getId());

            $difference = abs(count($popularTeamMembers) - count($notPopularTeamMembers));

            //一番人気のチームに参加しようとしてたら
            if ($teamId->equals($popularTeam->getId())) {
                //人数差が２以上ならダメ
                if ($difference >= 2) return false;
                PlayerDataStore::update(new PlayerData($playerName, $gameId, $teamId));
                return true;
            }

            PlayerDataStore::update(new PlayerData($playerName, $gameId, $teamId));
            return true;
        }
    }
}