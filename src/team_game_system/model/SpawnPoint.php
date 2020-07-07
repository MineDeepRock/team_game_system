<?php


namespace team_game_system\model;


use pocketmine\math\Vector3;

class SpawnPoint
{
    /**
     * @var TeamId
     */
    private $teamId;
    /**
     * @var Vector3
     */
    private $position;

    public function __construct(TeamId $teamId, Vector3 $position) {
        $this->teamId = $teamId;
        $this->position = $position;
    }

    /**
     * @return TeamId
     */
    public function getTeamId(): TeamId {
        return $this->teamId;
    }

    /**
     * @return Vector3
     */
    public function getPosition(): Vector3 {
        return $this->position;
    }
}