<?php


namespace team_game_system\model;


class GameType
{
    /**
     * @var string
     */
    private $text;

    public function __construct(string $text) {
        $this->text = $text;
    }

    public function __toString() {
        return $this->text;
    }

    public function equals(?GameType $type): bool {
        if ($type === null)
            return false;

        return $this->text === $type->text;
    }
}