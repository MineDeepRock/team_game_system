<?php


namespace team_game_system\pmmp\event;


use pocketmine\event\Event;
use pocketmine\Player;
use team_game_system\model\GameId;
use team_game_system\model\TeamId;

class PlayerQuitGameEvent extends Event
{
    /**
     * @var Player
     */
    private $player;
    /**
     * @var GameId|null
     */
    private $gameId;
    /**
     * @var TeamId|null
     */
    private $teamId;

    public function __construct(Player $player, ?GameId $gameId,?TeamId $teamId) {
        $this->player = $player;
        $this->gameId = $gameId;
        $this->teamId = $teamId;
    }

    /**
     * @return Player
     */
    public function getPlayer(): Player {
        return $this->player;
    }

    /**
     * @return GameId|null
     */
    public function getGameId(): ?GameId {
        return $this->gameId;
    }

    /**
     * @return TeamId|null
     */
    public function getTeamId(): ?TeamId {
        return $this->teamId;
    }
}