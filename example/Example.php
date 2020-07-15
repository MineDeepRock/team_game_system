<?php

namespace team_game_system\example;


use pocketmine\event\Listener;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Color;
use team_game_system\model\Game;
use team_game_system\model\Score;
use team_game_system\model\Team;
use team_game_system\pmmp\event\AddedScoreEvent;
use team_game_system\pmmp\event\FinishedGameEvent;
use team_game_system\pmmp\event\PlayerJoinedGameEvent;
use team_game_system\pmmp\event\PlayerKilledPlayerEvent;
use team_game_system\pmmp\event\StartedGameEvent;
use team_game_system\pmmp\event\UpdatedGameTimerEvent;
use team_game_system\TeamGameSystem;

class Example extends PluginBase implements Listener
{
    public function onEnable() {
        $teams = [
            Team::asNew("Red", new Color(255, 0, 0)),
            Team::asNew("Blue", new Color(0, 0, 255)),
            Team::asNew("Green", new Color(0, 255, 0)),
        ];
        $maxScore = new Score(25);
        $map = TeamGameSystem::selectMap("MapName",$teams);
        $game = Game::asNew($map, $teams, $maxScore);

        TeamGameSystem::createGame($game);
    }

    public function onPlayerKilledPlayer(PlayerKilledPlayerEvent $event): void {
        $attacker = $event->getAttacker();
        $attackerData = TeamGameSystem::getPlayerData($attacker);
        TeamGameSystem::addScore($attackerData->getGameId(), $attackerData->getTeamId(), new Score(1));
    }

    public function onUpdatedTime(UpdatedGameTimerEvent $event): void {
        $gameId = $event->getGameId();
        $timeLimit = $event->getTimeLimit();
        $elapsedTime = $event->getElapsedTime();
        //BossBarとかの更新
    }

    public function onAddedScore(AddedScoreEvent $event): void {
        //ScoreBoard更新とか勝利判定
    }

    public function onStartedGame(StartedGameEvent $event) {
        $gameId = $event->getGameId();
        $playersData = TeamGameSystem::getGamePlayersData($gameId);
        foreach ($playersData as $playerData) {
            $player = $this->getServer()->getPlayer($playerData->getName());

            TeamGameSystem::setSpawnPoint($player);

            //ワールド間をテレポートさせる場合は↓が必要
            $game = TeamGameSystem::getGame($gameId);
            $level = $this->getServer()->getLevelByName($game->getMap()->getName());
            $player->teleport($level->getSpawnLocation());
            //ワールド間をテレポートさせる場合は↑が必要

            //アイテムのセットなど.....
            $player->teleport($player->getSpawn());
        }
    }

    public function onFinishedGame(FinishedGameEvent $event): void {
        $game = $event->getGame();
        $playersData = $event->getPlayersData();

        foreach ($playersData as $playerData) {
            $player = $this->getServer()->getPlayer($playerData->getName());
            //テレポートやタイトル表示、リスポーン地点修正、ボスバースコアボード更新
        }
    }

    public function joinGame(Player $player) {
        //人数が一番少ないチーム
        $games = TeamGameSystem::getAllGames();
        $game = $games[array_rand($games)];
        TeamGameSystem::joinGame($player, $game->getId());

        //指定
        $team = $game->getTeams()[array_rand($game->getTeams())];
        TeamGameSystem::joinGame($player, $game->getId(), $team->getId());
    }

    public function onJoinGame(PlayerJoinedGameEvent $event) {
        $player = $event->getPlayer();
        $gameId = $event->getGameId();

        //10人でスタート
        $playersCount = TeamGameSystem::getGamePlayersData($gameId);
        if ($playersCount === 10) {
            TeamGameSystem::startGame($this->getScheduler(), $gameId);
        }
    }

    public function onRespawn(PlayerRespawnEvent $event){
        $player = $event->getPlayer();
        //アイテムのセットなど....
    }
}