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

    private $isStarted;

    public function __construct(GameId $id,Map $map,array $teams) {
        $this->id = $id;
        $this->map = $map;
        $this->teams = $teams;

        $this->isStarted = false;
    }

    static function asNew(Map $map, array $teams): Game {
        return new Game(GameId::asNew(), $map, $teams);
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
}