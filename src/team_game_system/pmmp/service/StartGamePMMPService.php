<?php

namespace team_game_system\pmmp\service;


use pocketmine\Server;
use team_game_system\model\GameId;
use team_game_system\store\PlayerDataStore;

class StartGamePMMPService
{
    static function execute(GameId $gameId): void {
        $players = PlayerDataStore::getGamePlayers($gameId);
        foreach ($players as $player) {
            SetSpawnPMMPService::execute(Server::getInstance()->getPlayer($player->getName()));
        }
    }
}