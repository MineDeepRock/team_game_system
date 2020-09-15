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

        //TODO:JoinGameServiceとコードが一部ダブっている
        //指定あり、強制
        if ($force) {
            PlayerDataStore::update(new PlayerData($playerName, $gameId, $teamId));
            return true;
            //指定あり、非強制
        } else {
            $teams = SortTeamsByPlayersCountService::execute($game->getTeams());
            if (count($teams) <= 1) {
                PlayerDataStore::update(new PlayerData($playerName, $gameId, $teamId));
                return true;
            }

            //人数の差を求める
            /** @var Team $popularTeam */
            $popularTeam = end($teams);
            $popularTeamMembers = TeamGameSystem::getTeamPlayersData($popularTeam->getId());

            /** @var Team $notPopularTeam */
            $notPopularTeam = $teams[0];
            $notPopularTeamMembers = TeamGameSystem::getTeamPlayersData($notPopularTeam->getId());

            $difference = abs(count($popularTeamMembers) - count($notPopularTeamMembers));

            //一番人気のチームに参加しようとしてたら
            if ($teamId->equals($popularTeam->getId())) {

                //人数差制限が設定されてなかったら
                if ($game->getMaxPlayersDifference() === null) {
                    PlayerDataStore::update(new PlayerData($playerName, $gameId, $teamId));
                    return true;
                } else {
                    //人数差が$maxPlayersDifferenceより大きければダメ
                    //どっちかのチームを抜けるため、差が+1される
                    if ($difference+1 >= $game->getMaxPlayersDifference()) return false;
                    PlayerDataStore::update(new PlayerData($playerName, $gameId, $teamId));
                    return true;
                }
            }

            PlayerDataStore::update(new PlayerData($playerName, $gameId, $teamId));
            return true;
        }
    }
}