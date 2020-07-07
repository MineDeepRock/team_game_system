<?php


namespace team_game_system\model;


class Map
{

    /**
     * @var string
     */
    private $name;
    /**
     * @var SpawnPoint[]
     */
    private $spawnPoints;

    public function __construct(string $name, array $spawnPoints) {
        $this->name = $name;
        $this->spawnPoints = $spawnPoints;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @return SpawnPoint[]
     */
    public function getSpawnPoints(): array {
        return $this->spawnPoints;
    }
}