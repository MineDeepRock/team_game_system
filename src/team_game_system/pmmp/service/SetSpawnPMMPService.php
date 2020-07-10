<?php


namespace team_game_system\pmmp\service;


use pocketmine\Player;
use team_game_system\store\GameStore;
use team_game_system\store\PlayerDataStore;

class SetSpawnPMMPService
{
    static function execute(Player $player): void {
        $playerData = PlayerDataStore::findByName($player->getName());
        $game = GameStore::findById($playerData->getGameId());
        $spawnPoints = $game->getMap()->getSpawnPoints()[strval($playerData->getTeamId())];

        $player->setSpawn($spawnPoints[mt_rand(0, count($spawnPoints) - 1)]->getPosition());
    }
}