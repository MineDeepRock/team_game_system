<?php


namespace team_game_system\pmmp\service;


use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\Server;
use team_game_system\store\GameStore;
use team_game_system\store\PlayerDataStore;

class SetSpawnPMMPService
{
    static function execute(Player $player): void {
        $playerData = PlayerDataStore::findByName($player->getName());
        $game = GameStore::findById($playerData->getGameId());
        $map = $game->getMap();
        $spawnPoints = [];
        foreach ($map->getSpawnPointGroups() as $spawnPointsGroup) {
            //TODO:nullだったら自前のエラーを吐くようにする
            if ($spawnPointsGroup->getTeamId()->equals($playerData->getTeamId())) {
                $spawnPoints = $spawnPointsGroup->getSpawnPoints();
            }
        }

        $pos = $spawnPoints[mt_rand(0, count($spawnPoints) - 1)]->getPosition();
        $level = Server::getInstance()->getLevelByName($map->getLevelName());
        $position = new Position($pos->getX(), $pos->getY(), $pos->getZ(), $level);

        $player->setSpawn($position);
    }
}