<?php


namespace team_game_system\store;


use team_game_system\data_model\PlayerData;
use team_game_system\model\GameId;
use team_game_system\model\TeamId;

class PlayerDataStore
{
    /**
     * @var PlayerData[]
     */
    static $playersData;

    static function add(PlayerData $playerData): void {
        self::$playersData[] = $playerData;
    }

    static function findByName(string $name): ?PlayerData {
        foreach (self::$playersData as $playerData) {
            if($playerData->getName() === $name) {
                return $playerData;
            }
        }

        return null;
    }

    static function getGamePlayers(GameId $gameId): array {
        $result = [];
        foreach (self::$playersData as $playerData) {
            if($playerData->getGameId()->equals($gameId)) {
                $result[] = $playerData;
            }
        }

        return $result;
    }


    static function getTeamPlayers(TeamId $teamId): array {
        $result = [];
        foreach (self::$playersData as $playerData) {
            if($playerData->getTeamId()->equals($teamId)) {
                $result[] = $playerData;
            }
        }

        return $result;
    }

    static function remove(string $name): void {
        $results = array_filter(self::$playersData, function ($playerData) use ($name) {
            return $playerData->getName() !== $name;
        });

        self::$playersData = $results;
    }

    static function update(PlayerData $playerData): void {
        self::remove($playerData->getName());
        self::add($playerData);
    }
}