<?php


namespace team_game_system\model;


class Map
{

    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $levelName;
    /**
     * @var SpawnPoint[]
     */
    private $spawnPoints;

    public function __construct(string $name, string $levelName, array $spawnPoints) {
        $this->name = $name;
        $this->levelName = $levelName;
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

    /**
     * @return string
     */
    public function getLevelName(): string {
        return $this->levelName;
    }
}