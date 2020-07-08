<?php


namespace team_game_system\pmmp\event;


use pocketmine\event\Event;
use pocketmine\Player;
use team_game_system\model\GameId;

class PlayerJoinGameEvent extends Event
{
    /**
     * @var Player
     */
    private $player;

    /**
     * @var GameId
     */
    private $gameId;

    public function __construct(Player $player, GameId $gameId) {
        $this->player = $player;
        $this->gameId = $gameId;
    }

    /**
     * @return Player
     */
    public function getPlayer(): Player {
        return $this->player;
    }

    /**
     * @return GameId
     */
    public function getGameId(): GameId {
        return $this->gameId;
    }
}