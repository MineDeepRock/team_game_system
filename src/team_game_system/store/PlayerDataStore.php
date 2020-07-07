<?php


namespace team_game_system\store;


use team_game_system\data_model\PlayerData;

class PlayerDataStore
{
    /**
     * @var PlayerData[]
     */
    static $playersData;

    static function add(PlayerData $playerData): void {
        self::$playersData[] = $playerData;
    }

    static function findByName(string $name): PlayerData {
        $results = array_filter(self::$playersData, function ($playerData) use ($name) {
            return $playerData->getName() === $name;
        });

        return $results[0];
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