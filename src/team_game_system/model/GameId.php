<?php


namespace team_game_system\model;


class GameId
{
    private $value;

    public function __construct(string $value) {
        $this->value = $value;
    }

    static function asNew(): GameId {
        return new GameId(uniqid());
    }

    public function __toString() {
        return $this->value;
    }
}