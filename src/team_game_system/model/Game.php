<?php

namespace team_game_system\model;


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
     * @var Score
     */
    private $maxScore;
    /**
     * @var int
     */
    private $maxPlayersCount;
    /**
     * @var int
     * second
     */
    private $timeLimit;

    private $isStarted;
    private $isClosed;

    public function __construct(GameId $id, Map $map, array $teams, ?Score $maxScore = null, ?int $maxPlayersCount = null, ?int $timeLimit = null) {
        $this->id = $id;
        $this->map = $map;
        $this->teams = $teams;

        $this->isStarted = false;
        $this->isClosed = false;
        $this->maxScore = $maxScore;
        $this->maxPlayersCount = $maxPlayersCount;
        $this->timeLimit = $timeLimit;
    }

    static function asNew(Map $map, array $teams, ?Score $maxScore = null, ?int $maxPlayersCount = null, ?int $timeLimit = null): Game {
        return new Game(GameId::asNew(), $map, $teams, $maxScore, $maxPlayersCount, $timeLimit);
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
     * @return Team[]
     */
    public function getTeams(): array {
        return $this->teams;
    }

    public function start(): void {
        $this->isStarted = true;
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