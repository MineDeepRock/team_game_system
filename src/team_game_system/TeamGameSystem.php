<?php


namespace team_game_system;


use pocketmine\Player;
use pocketmine\scheduler\TaskScheduler;
use team_game_system\data_model\PlayerData;
use team_game_system\model\Game;
use team_game_system\model\GameId;
use team_game_system\model\Map;
use team_game_system\model\Score;
use team_game_system\model\TeamId;
use team_game_system\pmmp\service\SetSpawnPMMPService;
use team_game_system\service\AdaptMapToTeamsService;
use team_game_system\service\AddScoreService;
use team_game_system\service\CreateGameService;
use team_game_system\service\FinishGameService;
use team_game_system\service\JoinGameService;
use team_game_system\service\LoadMapService;
use team_game_system\service\StartGameService;
use team_game_system\store\GameStore;
use team_game_system\store\PlayerDataStore;

//API層
class TeamGameSystem
{
    static function createGame(Game $game): void {
        CreateGameService::execute($game);
    }

    static function startGame(TaskScheduler $scheduler, GameId $gameId): void {
        StartGameService::execute($scheduler, $gameId);
    }

    static function finishedGame(GameId $gameId): void {
        FinishGameService::execute($gameId);
    }

    static function joinGame(Player $player, GameId $gameId, ?TeamId $teamId = null): bool {
        return JoinGameService::execute($player, $gameId, $teamId);
    }

    static function setSpawnPoint(Player $player): void {
        SetSpawnPMMPService::execute($player);
    }

    static function selectMap(string $name, array $teams): Map {
        return AdaptMapToTeamsService::execute(LoadMapService::findByName($name), $teams);
    }

    static function addScore(GameId $gameId, TeamId $teamId, Score $score): void {
        AddScoreService::execute($gameId, $teamId, $score);
    }

    static function getPlayerData(Player $player): PlayerData {
        return PlayerDataStore::findByName($player->getName());
    }

    static function getGamePlayersData(GameId $gameId): array {
        return PlayerDataStore::getGamePlayers($gameId);
    }

    static function getTeamPlayersData(TeamId $teamId): array {
        return PlayerDataStore::getTeamPlayers($teamId);
    }

    static function getGame(GameId $gameId): ?Game {
        return GameStore::findById($gameId);
    }
}