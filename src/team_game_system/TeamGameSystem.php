<?php


namespace team_game_system;


use pocketmine\Player;
use pocketmine\scheduler\TaskScheduler;
use team_game_system\data_model\PlayerData;
use team_game_system\model\Game;
use team_game_system\model\GameId;
use team_game_system\model\GameType;
use team_game_system\model\Map;
use team_game_system\model\Score;
use team_game_system\model\Team;
use team_game_system\model\TeamId;
use team_game_system\pmmp\service\AddScorePMMPService;
use team_game_system\pmmp\service\FinishGamePMMPService;
use team_game_system\pmmp\service\JoinGamePMMPService;
use team_game_system\pmmp\service\QuitGamePMMPService;
use team_game_system\pmmp\service\SetSpawnPMMPService;
use team_game_system\pmmp\service\StartGamePMMPService;
use team_game_system\service\AdaptMapToTeamsService;
use team_game_system\service\AddScoreService;
use team_game_system\service\QuitGameService;
use team_game_system\service\RegisterGameService;
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
    static function registerGame(Game $game): void {
        RegisterGameService::execute($game);
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

    static function joinGame(Player $player, GameId $gameId, ?TeamId $teamId = null, bool $force = false): bool {
        $playerData = PlayerDataStore::findByName($player->getName());
        if ($playerData === null) return false;

        if ($playerData->getGameId() !== null) return false;

        $result = JoinGameService::execute($player->getName(), $gameId, $teamId, $force);

        if ($result) {
            JoinGamePMMPService::execute($player, $gameId);
        }

        return $result;
    }

    static function quitGame(Player $player) {
        $playerData = PlayerDataStore::findByName($player->getName());
        QuitGameService::execute($player->getName());
        QuitGamePMMPService::execute($player, $playerData->getGameId(), $playerData->getTeamId());
    }

    static function setSpawnPoint(Player $player): void {
        SetSpawnPMMPService::execute($player);
    }

    static function selectMap(string $name, array $teams): Map {
        return AdaptMapToTeamsService::execute(MapsStore::findByName($name), $teams);
    }

    static function addScore(GameId $gameId, TeamId $teamId, Score $score): void {
        $result = AddScoreService::execute($gameId, $teamId, $score);
        if ($result) {
            AddScorePMMPService::execute($gameId, $teamId, $score);
        }
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

    static function findGamesByType(GameType $gameType): array {
        return GameStore::findByType($gameType);
    }

    static function getTeam(GameId $gameId, TeamId $teamId): ?Team {
        $game = GameStore::findById($gameId);
        if ($game === null) return null;
        foreach ($game->getTeams() as $team) {
            if ($team->getId()->equals($teamId)) return $team;
        }

        return null;
    }
}