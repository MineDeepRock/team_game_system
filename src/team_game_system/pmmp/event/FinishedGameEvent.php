<?php


namespace team_game_system\pmmp\event;


use pocketmine\event\Event;
use team_game_system\data_model\PlayerData;
use team_game_system\model\Game;

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

    public function __construct(Game $game, array $playersData) {
        $this->game = $game;
        $this->playersData = $playersData;
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
}