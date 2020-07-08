<?php

namespace team_game_system\store;


use team_game_system\model\Game;
use team_game_system\model\GameId;

class GameStore
{
    /**
     * @var Game[]
     */
    static private $games;

    static function add(Game $game): void {
        $game[] = $game;
    }

    static function delete(GameId $gameId): void {

        foreach (self::$games as $game) {
            if($game->getId()->equals($gameId)) unset($game);
        }
    }

    static function findById(GameId $gameId): Game {
        $results = array_filter(self::$games, function ($game) use ($gameId) {
            return $game->getId()->equals($gameId);
        });

        return $results[0];
    }

    static function getAll(): array {
        return self::$games;
    }
}