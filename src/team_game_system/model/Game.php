<?php

namespace team_game_system\model;


use pocketmine\scheduler\ClosureTask;
use pocketmine\scheduler\TaskHandler;
use pocketmine\scheduler\TaskScheduler;
use team_game_system\pmmp\event\UpdatedGameTimerEvent;
use team_game_system\pmmp\service\FinishGamePMMPService;
use team_game_system\service\FinishGameService;
use team_game_system\store\GameStore;
use team_game_system\store\PlayerDataStore;

class Game
{
    /**
     * @var GameId
     */
    private $id;
    /**
     * @var GameType
     */
    private $type;
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
     */
    private $maxPlayersDifference;
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

    private function __construct(GameId $id, GameType $type, Map $map, array $teams, ?Score $maxScore = null, ?int $maxPlayersCount = null, ?int $maxPlayersDifference = null, ?int $timeLimit = null, ?int $elapsedTime = null, $isStarted = false, $isClosed = false) {
        $this->id = $id;
        $this->type = $type;
        $this->map = $map;
        $this->teams = $teams;

        $this->isStarted = $isStarted;
        $this->isClosed = $isClosed;

        $this->maxScore = $maxScore;
        $this->maxPlayersCount = $maxPlayersCount;
        $this->maxPlayersDifference = $maxPlayersDifference;
        $this->timeLimit = $timeLimit;

        $this->elapsedTime = $elapsedTime;
    }

    static function asNew(GameType $type, Map $map, array $teams): Game {
        return new Game(GameId::asNew(), $type, $map, $teams);
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

    public function start(): void {
        $this->isStarted = true;
    }

    public function pass(int $second): void {
        $this->elapsedTime += 1;
    }

    public function close(): void {
        $this->isClosed = true;
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
     * @return Score|null
     */
    public function getMaxScore(): ?Score {
        return $this->maxScore;
    }

    /**
     * @return int|null
     */
    public function getMaxPlayersCount(): ?int {
        return $this->maxPlayersCount;
    }

    /**
     * @return int|null
     */
    public function getMaxPlayersDifference(): ?int {
        return $this->maxPlayersDifference;
    }

    /**
     * @return int|null
     */
    public function getTimeLimit(): ?int {
        return $this->timeLimit;
    }

    /**
     * @return int|null
     */
    public function getElapsedTime(): ?int {
        return $this->elapsedTime;
    }

    /**
     * @return GameType
     */
    public function getType(): GameType {
        return $this->type;
    }

    /**
     * @param Score|null $maxScore
     */
    public function setMaxScore(?Score $maxScore): void {
        $this->maxScore = $maxScore;
    }

    /**
     * @param int|null $maxPlayersCount
     */
    public function setMaxPlayersCount(?int $maxPlayersCount): void {
        $this->maxPlayersCount = $maxPlayersCount;
    }

    /**
     * @param int|null $maxPlayersDifference
     */
    public function setMaxPlayersDifference(?int $maxPlayersDifference): void {
        $this->maxPlayersDifference = $maxPlayersDifference;
    }

    /**
     * @param int|null $timeLimit
     */
    public function setTimeLimit(?int $timeLimit): void {
        $this->timeLimit = $timeLimit;
    }
}