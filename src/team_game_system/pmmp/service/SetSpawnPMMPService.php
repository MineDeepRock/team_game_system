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
        $spawnPoints = [];
        foreach ($game->getMap()->getSpawnPoints() as $spawnPoint){
            if ($spawnPoint->getTeamId()->equals($playerData->getTeamId())){
                $spawnPoints[] = $spawnPoint;
            }
        }

        $player->setSpawn(array_rand($spawnPoints)->getPosition());
    }
}