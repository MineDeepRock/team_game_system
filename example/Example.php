<?php

namespace team_game_system\example;


use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Color;
use team_game_system\model\Game;
use team_game_system\model\Score;
use team_game_system\model\Team;
use team_game_system\pmmp\event\AddedScoreEvent;
use team_game_system\pmmp\event\FinishedGameEvent;
use team_game_system\pmmp\event\PlayerKilledPlayerEvent;
use team_game_system\pmmp\event\UpdatedGameTimerEvent;
use team_game_system\store\GameStore;
use team_game_system\TeamGameSystem;

class Example extends PluginBase implements Listener
{
    public function onEnable() {
        $map = TeamGameSystem::randomSelectMap();
        $teams = [
            Team::asNew("Red", new Color(255, 0, 0)),
            Team::asNew("Blue", new Color(0, 0, 255)),
            Team::asNew("Green", new Color(0, 255, 0)),
        ];
        $maxScore = new Score(25);
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
        $game = array_rand(GameStore::getAll());
        TeamGameSystem::joinGame($player, $game->getId());

        //指定
        $team = array_rand($game->getTeams());
        TeamGameSystem::joinGame($player, $game->getId(), $team->getId());
    }
}