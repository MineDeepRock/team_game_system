<?php


namespace team_game_system\model;


class Map
{

    private $name;
    private $spawnPoints;

    public function __construct(string $name, array $spawnPoints) {
        $this->name = $name;
        $this->spawnPoints = $spawnPoints;
    }
}