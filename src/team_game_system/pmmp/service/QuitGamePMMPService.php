<?php


namespace team_game_system\pmmp\service;


use pocketmine\Player;
use team_game_system\model\GameId;
use team_game_system\pmmp\event\PlayerQuitGameEvent;

class QuitGamePMMPService
{
    static function execute(Player $player, GameId $gameId) {
        $event = new PlayerQuitGameEvent($player, $gameId);
        $event->call();
    }
}