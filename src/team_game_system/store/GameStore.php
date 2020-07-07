<?php

namespace team_game_system\store;


use team_game_system\model\Game;

class GameStore
{
    static private $games;

    static function add(Game $game): void {
        $game[] = $game;
    }
}