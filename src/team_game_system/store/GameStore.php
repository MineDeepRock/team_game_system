<?php

namespace team_game_system\store;


use team_game_system\model\Game;
use team_game_system\model\GameId;

class GameStore
{
    /**
     * @var Game[]
     */
    static private $games = [];

    static function add(Game $game): void {
        self::$games[] = $game;
    }

    static function delete(GameId $gameId): void {

        foreach (self::$games as $game) {
            if($game->getId()->equals($gameId)) unset($game);
        }

        self::$games = array_values(self::$games);
    }

    static function findById(GameId $gameId): ?Game {

        foreach (self::$games as $game) {
            if ($game->getId()->equals($gameId)) {
                return $game;
            }
        }

        return null;
    }

    /**
     * @return array|Game[]
     */
    static function getAll(): array {
        return self::$games;
    }
}