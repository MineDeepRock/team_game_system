<?php

namespace team_game_system\pmmp\event;


use pocketmine\event\Event;
use team_game_system\model\GameId;

class StartedGameEvent extends Event
{
    /**
     * @var GameId
     */
    private $gameId;

    public function __construct(GameId $gameId) {
        $this->gameId = $gameId;
    }

    /**
     * @return GameId
     */
    public function getGameId(): GameId {
        return $this->gameId;
    }
}