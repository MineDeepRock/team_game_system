<?php

namespace team_game_system\model;


class Score
{
    private $value;

    public function __construct(int $value) {
        $this->value = $value;
    }

    static function asNew(): Score {
        return new Score(0);
    }

    /**
     * @return int
     */
    public function getValue(): int {
        return $this->value;
    }
}