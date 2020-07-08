<?php

namespace team_game_system\model;


use pocketmine\utils\Color;

class Team
{
    /**
     * @var TeamId
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var Color
     */
    private $teamColor;
    /**
     * @var Score
     */
    private $score;

    public function __construct(TeamId $id, string $name, Color $teamColor, Score $score) {
        $this->id = $id;
        $this->name = $name;
        $this->teamColor = $teamColor;
        $this->score = $score;
    }

    static function asNew(string $name, Color $teamColor): Team {
        return new Team(TeamId::asNew(), $name, $teamColor, Score::asNew());
    }

    /**
     * @return Score
     */
    public function getScore(): Score {
        return $this->score;
    }

    /**
     * @return TeamId
     */
    public function getId(): TeamId {
        return $this->id;
    }

    public function add(Score $score): void {
        $this->score += $score->getValue();
    }

    /**
     * @param Score $score
     */
    public function setScore(Score $score): void {
        $this->score = $score;
    }
}