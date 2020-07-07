<?php


namespace team_game_system\model;


use pocketmine\math\Vector3;

class SpawnPoint
{
    private $teamId;
    private $position;

    public function __construct(TeamId $teamId, Vector3 $position) {
        $this->teamId = $teamId;
        $this->position = $position;
    }
}