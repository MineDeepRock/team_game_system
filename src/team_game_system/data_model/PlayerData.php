<?php

namespace team_game_system\data_model;


class PlayerData
{
    private $name;
    private $teamId;

    public function __construct($name, $teamId) {
        $this->name = $name;
        $this->teamId = $teamId;
    }
}