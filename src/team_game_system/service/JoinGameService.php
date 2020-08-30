<?php


namespace team_game_system\service;


use team_game_system\data_model\PlayerData;
use team_game_system\model\GameId;
use team_game_system\model\TeamId;
use team_game_system\store\GameStore;
use team_game_system\store\PlayerDataStore;
use team_game_system\TeamGameSystem;

class JoinGameService
{
    static function execute(string $playerName, GameId $gameId, ?TeamId $teamId, bool $force = false): bool {
        $game = GameStore::findById($gameId);
        if ($game->isClosed()) return false;

        //人数制限
        $playersCount = count(PlayerDataStore::getGamePlayers($gameId));
        if ($game->getMaxPlayersCount() !== null) {
            if ($game->getMaxPlayersCount() === $playersCount) return false;
        }

        //チーム指定無し
        if ($teamId === null) {
            $teamId = SortTeamsByPlayersCountService::execute($game->getTeams())[0]->getId();
            PlayerDataStore::update(new PlayerData($playerName, $gameId, $teamId));
            return true;
        }

        //強制
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
            $popularTeam = $teams[0];
            $popularTeamMembers = TeamGameSystem::getTeamPlayersData($popularTeam->getId());

            $notPopularTeam = end($teams);
            $notPopularTeamMembers = TeamGameSystem::getTeamPlayersData($notPopularTeam->getId());

            $difference = abs(count($popularTeamMembers) - count($notPopularTeamMembers));

            //一番人気のチームに参加しようとしてたら
            if ($teamId->equals($popularTeam->getTeamId())) {
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