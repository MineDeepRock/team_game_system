<?php

namespace team_game_system\service;


use pocketmine\scheduler\ClosureTask;
use pocketmine\scheduler\TaskScheduler;
use team_game_system\model\GameId;
use team_game_system\pmmp\event\UpdatedGameTimerEvent;
use team_game_system\pmmp\service\FinishGamePMMPService;
use team_game_system\store\GameStore;
use team_game_system\store\GameTimerTaskHandlersStore;
use team_game_system\store\PlayerDataStore;

class StartGameService
{
    static function execute(TaskScheduler $scheduler, GameId $gameId): void {
        $game = GameStore::findById($gameId);
        $game->start();

        //TODO:これ本当にここか？
        $timerHandler = $scheduler->scheduleDelayedRepeatingTask(new ClosureTask(function (int $currentTick) use ($gameId): void {
            $game = GameStore::findById($gameId);
            $game->pass(1);

            if ($game->getTimeLimit() !== null) {
                if ($game->getTimeLimit() <= $game->getElapsedTime()) {
                    $playersData = PlayerDataStore::getGamePlayers($gameId);
                    FinishGameService::execute($gameId);
                    FinishGamePMMPService::execute($game, $playersData);
                }
            }

            if (!$game->isClosed()) {
                $event = new UpdatedGameTimerEvent($gameId, $game->getTimeLimit(), $game->getElapsedTime());
                $event->call();
            }
        }), 20, 20);

        GameTimerTaskHandlersStore::add($gameId, $timerHandler);
    }
}