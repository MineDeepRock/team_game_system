<?php

namespace team_game_system\model;


class Score
{
    private $teamId;
    private $value;

    public function __construct(TeamId $teamId, int $value) {
        $this->teamId = $teamId;
        $this->value = $value;
    }

    static function asNew(TeamId $teamId): Score {
        return new Score($teamId, 0);
    }
}