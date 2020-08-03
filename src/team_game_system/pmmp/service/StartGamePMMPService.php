<?php

namespace team_game_system\pmmp\service;


use pocketmine\Server;
use team_game_system\model\GameId;
use team_game_system\pmmp\event\StartedGameEvent;
use team_game_system\store\GameStore;

class StartGamePMMPService
{
    static function execute(GameId $gameId): void {
        $map = GameStore::findById($gameId)->getMap();
        Server::getInstance()->loadLevel($map->getLevelName());

        $event = new StartedGameEvent($gameId);
        $event->call();
    }
}