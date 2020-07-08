<?php


namespace team_game_system\pmmp\event;


use pocketmine\event\Event;
use team_game_system\model\GameId;
use team_game_system\model\Score;
use team_game_system\model\TeamId;

class AddedScoreEvent extends Event
{
    /**
     * @var GameId
     */
    private $gameId;
    /**
     * @var TeamId
     */
    private $teamId;
    /**
     * @var Score
     */
    private $totalScore;
    /**
     * @var Score
     */
    private $scoreAdded;

    public function __construct(GameId $gameId, TeamId $teamId, Score $totalScore, Score $scoreAdded) {
        $this->gameId = $gameId;
        $this->teamId = $teamId;
        $this->totalScore = $totalScore;
        $this->scoreAdded = $scoreAdded;
    }

    /**
     * @return GameId
     */
    public function getGameId(): GameId {
        return $this->gameId;
    }

    /**
     * @return TeamId
     */
    public function getTeamId(): TeamId {
        return $this->teamId;
    }

    /**
     * @return Score
     */
    public function getTotalScore(): Score {
        return $this->totalScore;
    }

    /**
     * @return Score
     */
    public function getScoreAdded(): Score {
        return $this->scoreAdded;
    }
}