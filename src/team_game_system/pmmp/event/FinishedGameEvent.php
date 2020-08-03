<?php


namespace team_game_system\pmmp\event;


use pocketmine\event\Event;
use team_game_system\data_model\PlayerData;
use team_game_system\model\Game;
use team_game_system\model\Team;

class FinishedGameEvent extends Event
{
    /**
     * @var Game
     */
    private $game;
    /**
     * @var PlayerData[]
     */
    private $playersData;

    /**
     * @var Team|null
     */
    private $wonTeam;

    public function __construct(Game $game, array $playersData, ?Team $wonTeam) {
        $this->game = $game;
        $this->playersData = $playersData;
        $this->wonTeam = $wonTeam;
    }

    /**
     * @return Game
     */
    public function getGame(): Game {
        return $this->game;
    }

    /**
     * @return PlayerData[]
     */
    public function getPlayersData(): array {
        return $this->playersData;
    }

    /**
     * 引き分けのときはnull
     * @return Team|null
     */
    public function getWonTeam(): ?Team {
        return $this->wonTeam;
    }
}