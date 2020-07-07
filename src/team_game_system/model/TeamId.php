<?php

namespace team_game_system\model;


class TeamId
{
    private $value;

    public function __construct(string $value) {
        $this->value = $value;
    }

    static function asNew(): TeamId {
        return new TeamId(uniqid());
    }

    public function __toString() {
        return $this->value;
    }

    public function equals(?TeamId $id): bool {
        if ($id === null)
            return false;

        return $this->value === $id->value;
    }
}