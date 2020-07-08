<?php

namespace team_game_system\service;


use pocketmine\scheduler\ClosureTask;
use pocketmine\scheduler\TaskScheduler;
use team_game_system\model\GameId;
use team_game_system\pmmp\service\StartGamePMMPService;
use team_game_system\store\GameStore;

class StartGameService
{
    static function execute(TaskScheduler $scheduler, GameId $gameId): void {
        $game = GameStore::findById($gameId);
        $game->start($scheduler);

        StartGamePMMPService::execute($gameId);
    }
}