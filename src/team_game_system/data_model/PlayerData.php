<?php

namespace team_game_system\data_model;


use team_game_system\model\GameId;
use team_game_system\model\TeamId;

class PlayerData
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var GameId|null
     */
    private $gameId;
    /**
     * @var TeamId|null
     */
    private $teamId;

    public function __construct(string $name, ?GameId $gameId, ?TeamId $teamId) {
        $this->name = $name;
        $this->teamId = $teamId;
        $this->gameId = $gameId;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @return TeamId|null
     */
    public function getTeamId(): ?TeamId {
        return $this->teamId;
    }

    /**
     * @return GameId|null
     */
    public function getGameId(): ?GameId {
        return $this->gameId;
    }
}