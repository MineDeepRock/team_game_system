<?php


namespace team_game_system\model;


use pocketmine\math\Vector3;

class SpawnPoint
{
    /**
     * @var Vector3
     */
    private $position;

    public function __construct(Vector3 $position) {
        $this->position = $position;
    }

    /**
     * @return Vector3
     */
    public function getPosition(): Vector3 {
        return $this->position;
    }
}