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
     * @var SpawnPointsGroup[]
     */
    private $spawnPointGroups;

    public function __construct(string $name, string $levelName, array $spawnPointsGroups) {
        $this->name = $name;
        $this->levelName = $levelName;
        $this->spawnPointGroups = $spawnPointsGroups;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @return SpawnPointsGroup[]
     */
    public function getSpawnPointGroups(): array {
        return $this->spawnPointGroups;
    }

    /**
     * @return string
     */
    public function getLevelName(): string {
        return $this->levelName;
    }
}