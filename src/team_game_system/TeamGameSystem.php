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
use team_game_system\pmmp\service\AddScorePMMPService;
use team_game_system\pmmp\service\FinishGamePMMPService;
use team_game_system\pmmp\service\JoinGamePMMPService;
use team_game_system\pmmp\service\SetSpawnPMMPService;
use team_game_system\pmmp\service\StartGamePMMPService;
use team_game_system\service\AdaptMapToTeamsService;
use team_game_system\service\AddScoreService;
use team_game_system\service\CreateGameService;
use team_game_system\service\FinishGameService;
use team_game_system\service\JoinGameService;
use team_game_system\service\StartGameService;
use team_game_system\store\GameStore;
use team_game_system\store\MapsStore;
use team_game_system\store\PlayerDataStore;

//API層
class TeamGameSystem
{
    //Game
    static function createGame(Game $game): void {
        CreateGameService::execute($game);
    }

    static function startGame(TaskScheduler $scheduler, GameId $gameId): void {
        StartGameService::execute($scheduler, $gameId);
        StartGamePMMPService::execute($gameId);
    }

    static function finishedGame(GameId $gameId): void {
        $playersData = PlayerDataStore::getGamePlayers($gameId);
        $game = GameStore::findById($gameId);

        FinishGameService::execute($gameId);
        FinishGamePMMPService::execute($game, $playersData);
    }

    static function joinGame(Player $player, GameId $gameId, ?TeamId $teamId = null): bool {
        $result =  JoinGameService::execute($player->getName(), $gameId, $teamId);

        if ($result) {
            JoinGamePMMPService::execute($player, $gameId);
            return true;
        }

        return false;
    }

    static function setSpawnPoint(Player $player): void {
        SetSpawnPMMPService::execute($player);
    }

    static function selectMap(string $name, array $teams): Map {
        return AdaptMapToTeamsService::execute(MapsStore::findByName($name), $teams);
    }

    static function addScore(GameId $gameId, TeamId $teamId, Score $score): void {
        AddScoreService::execute($gameId, $teamId, $score);
        AddScorePMMPService::execute($gameId, $teamId, $score);
    }

    //PlayerData
    static function getPlayerData(Player $player): PlayerData {
        return PlayerDataStore::findByName($player->getName());
    }

    static function getGamePlayersData(GameId $gameId): array {
        return PlayerDataStore::getGamePlayers($gameId);
    }

    static function getTeamPlayersData(TeamId $teamId): array {
        return PlayerDataStore::getTeamPlayers($teamId);
    }

    //Game
    static function getAllGames(): array {
        return GameStore::getAll();
    }
    static function getGame(GameId $gameId): ?Game {
        return GameStore::findById($gameId);
    }
}