<?php


namespace team_game_system\store;


use pocketmine\scheduler\TaskHandler;
use team_game_system\model\GameId;

class GameTimerTaskHandlersStore
{
    /**
     * @var TaskHandler[]
     */
    static private $handlers = [];

    static function add(GameId $gameId, TaskHandler $taskHandler): void {
        self::$handlers[strval($gameId)] = $taskHandler;
    }

    static function delete(GameId $gameId): void {

        foreach (self::$handlers as $gameIdAsString => $handler) {
            if ($gameIdAsString === strval($gameId)) unset(self::$handlers[$gameIdAsString]);
        }
    }

    static function findByGameId(GameId $gameId): ?TaskHandler {

        foreach (self::$handlers as $gameIdAsString => $handler) {
            if ($gameIdAsString === strval($gameId)) {
                return $handler;
            }
        }

        return null;
    }

    /**
     * @return array|TaskHandler[]
     */
    static function getAll(): array {
        return self::$handlers;
    }
}