<?php


namespace team_game_system\pmmp\event;


use pocketmine\event\Event;
use pocketmine\Player;

class PlayerQuitGameEvent extends Event
{
    /**
     * @var Player
     */
    private $player;

    public function __construct(Player $player) {
        $this->player = $player;
    }

    /**
     * @return Player
     */
    public function getPlayer(): Player {
        return $this->player;
    }
}