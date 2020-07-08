<?php


namespace team_game_system\pmmp\event;


use pocketmine\event\Event;
use pocketmine\Player;

class PlayerKilledPlayerEvent extends Event
{
    /**
     * @var Player
     */
    private $attacker;
    /**
     * @var Player
     */
    private $target;

    public function __construct(Player $attacker, Player $target) {
        $this->attacker = $attacker;
        $this->target = $target;
    }

    /**
     * @return Player
     */
    public function getAttacker(): Player {
        return $this->attacker;
    }

    /**
     * @return Player
     */
    public function getTarget(): Player {
        return $this->target;
    }
}