<?php

namespace team_game_system\model;


use pocketmine\scheduler\ClosureTask;
use pocketmine\scheduler\TaskHandler;
use pocketmine\scheduler\TaskScheduler;
use team_game_system\pmmp\event\UpdatedGameTimerEvent;
use team_game_system\service\FinishGameService;
use team_game_system\store\GameStore;

class Game
{
    /**
     * @var GameId
     */
    private $id;
    /**
     * @var Map
     */
    private $map;
    /**
     * @var Team[]
     */
    private $teams;
    /**
     * @var Score|null
     */
    private $maxScore;
    /**
     * @var int|null
     */
    private $maxPlayersCount;
    /**
     * @var int|null
     * second
     */
    private $timeLimit;
    /**
     * @var int|null
     * second
     */
    private $elapsedTime;

    private $isStarted;
    private $isClosed;

    /**
     * @var TaskHandler
     */
    private $timerHandler;

    public function __construct(GameId $id, Map $map, array $teams, ?Score $maxScore = null, ?int $maxPlayersCount = null, ?int $timeLimit = null, ?int $elapsedTime = null) {
        $this->id = $id;
        $this->map = $map;
        $this->teams = $teams;

        $this->isStarted = false;
        $this->isClosed = false;
        $this->maxScore = $maxScore;
        $this->maxPlayersCount = $maxPlayersCount;
        $this->timeLimit = $timeLimit;
        $this->elapsedTime = $elapsedTime;
    }

    static function asNew(Map $map, array $teams, ?Score $maxScore = null, ?int $maxPlayersCount = null, ?int $timeLimit = null): Game {
        return new Game(GameId::asNew(), $map, $teams, $maxScore, $maxPlayersCount, $timeLimit, 0);
    }

    /**
     * @return GameId
     */
    public function getId(): GameId {
        return $this->id;
    }

    /**
     * @return Map
     */
    public function getMap(): Map {
        return $this->map;
    }

    /**
     * @return array|Team[]
     */
    public function getTeams(): array {
        return $this->teams;
    }

    public function start(TaskScheduler $scheduler): void {
        $this->isStarted = true;

        //TODO:これ本当にここか？
        $this->timerHandler = $scheduler->scheduleDelayedRepeatingTask(new ClosureTask(function (int $currentTick): void {
            $this->elapsedTime += 1;
            $event = new UpdatedGameTimerEvent($this->id, $this->timeLimit, $this->elapsedTime);
            $event->call();
            if ($this->timeLimit <= $this->elapsedTime) {
                FinishGameService::execute($this->id);
            }
        }), 20, 20);
    }

    public function close(): void {
        $this->isClosed = true;
        $this->timerHandler->cancel();
    }

    /**
     * @return bool
     */
    public function isStarted(): bool {
        return $this->isStarted;
    }

    /**
     * @return bool
     */
    public function isClosed(): bool {
        return $this->isClosed;
    }

    /**
     * @return Score
     */
    public function getMaxScore(): Score {
        return $this->maxScore;
    }

    /**
     * @return int
     */
    public function getMaxPlayersCount(): int {
        return $this->maxPlayersCount;
    }

    /**
     * @return int
     */
    public function getTimeLimit(): int {
        return $this->timeLimit;
    }
}