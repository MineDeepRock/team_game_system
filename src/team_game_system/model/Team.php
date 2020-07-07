<?php

namespace team_game_system\model;


use pocketmine\utils\Color;

class Team
{
    private $id;
    private $name;
    private $teamColor;

    public function __construct(TeamId $id, string $name, Color $teamColor) {
        $this->id = $id;
        $this->name = $name;
        $this->teamColor = $teamColor;
    }

    static function asNew(string $name, Color $teamColor): Team {
        return new Team(TeamId::asNew(), $name, $teamColor);
    }
}