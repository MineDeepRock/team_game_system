<?php


namespace team_game_system\model;


class SpawnPointsGroup
{
    /**
     * @var TeamId|null
     */
    private $teamId;
    /**
     * @var SpawnPoint[]
     */
    private $spawnPoints;

    public function __construct(array $spawnPoints, ?TeamId $teamId = null) {
        $this->spawnPoints = $spawnPoints;
        $this->teamId = $teamId;
    }

    /**
     * @return TeamId|null
     */
    public function getTeamId(): ?TeamId {
        return $this->teamId;
    }

    /**
     * @return SpawnPoint[]
     */
    public function getSpawnPoints(): array {
        return $this->spawnPoints;
    }
}