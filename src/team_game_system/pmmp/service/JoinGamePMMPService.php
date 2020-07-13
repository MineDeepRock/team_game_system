<?php


namespace team_game_system\pmmp\service;


use pocketmine\Player;
use team_game_system\model\GameId;
use team_game_system\pmmp\event\PlayerJoinedGameEvent;

class JoinGamePMMPService
{
    static function execute(Player $player, GameId $gameId): void {
        $event = new PlayerJoinedGameEvent($player,$gameId);
        $event->call();
    }
}