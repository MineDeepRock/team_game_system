<?php


namespace team_game_system\pmmp\event;


use pocketmine\event\Event;
use team_game_system\model\GameId;

class UpdatedGameTimerEvent extends Event
{
    /**
     * @var GameId
     */
    private $gameId;
    /**
     * @var int|null
     */
    private $timeLimit;
    /**
     * @var int
     */
    private $elapsedTime;

    public function __construct(GameId $gameId, ?int $timeLimit, int $elapsedTime) {
        $this->gameId = $gameId;
        $this->timeLimit = $timeLimit;
        $this->elapsedTime = $elapsedTime;
    }

    /**
     * @return GameId
     */
    public function getGameId(): GameId {
        return $this->gameId;
    }

    /**
     * @return int|null
     */
    public function getTimeLimit(): ?int {
        return $this->timeLimit;
    }

    /**
     * @return int
     */
    public function getElapsedTime(): int {
        return $this->elapsedTime;
    }
}