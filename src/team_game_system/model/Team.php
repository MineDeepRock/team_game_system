<?php

namespace team_game_system\model;


use form_builder\models\simple_form_elements\SimpleFormButton;
use pocketmine\utils\Color;
use pocketmine\utils\TextFormat;

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
     * @var string
     */
    private $teamColorFormat;
    /**
     * @var Score
     */
    private $score;

    public function __construct(TeamId $id, string $name, string $teamColorFormat, Score $score) {
        $this->id = $id;
        $this->name = $name;
        $this->teamColorFormat = $teamColorFormat;
        $this->score = $score;
    }

    static function asNew(string $name, string $teamColorFormat): Team {
        return new Team(TeamId::asNew(), $name, $teamColorFormat, Score::asNew());
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

    public function addScore(Score $score): void {
        $this->score = new Score($this->score->getValue() + $score->getValue());
    }

    /**
     * @param Score $score
     */
    public function setScore(Score $score): void {
        $this->score = $score;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getTeamColorFormat(): string {
        return $this->teamColorFormat;
    }
}