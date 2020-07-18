<?php

use PHPUnit\Framework\TestCase;
use pocketmine\utils\Color;
use team_game_system\model\Game;
use team_game_system\model\Score;
use team_game_system\model\Team;
use team_game_system\service\JoinGameService;
use team_game_system\store\GameStore;
use team_game_system\store\PlayerDataStore;
use team_game_system\TeamGameSystem;

class TestGame extends TestCase
{
    public function testCreateGame() {
        $teams = [
            Team::asNew("Red", new Color(255, 0, 0)),
            Team::asNew("Blue", new Color(0, 0, 255)),
            Team::asNew("Green", new Color(0, 255, 0)),
        ];
        $map = TeamGameSystem::selectMap("map", $teams);
        $game = Game::asNew($map, $teams);

        TeamGameSystem::registerGame($game);

        $this->assertNotNull(GameStore::findById($game->getId()));
    }

    public function testAddScore() {
        $game = GameStore::getAll()[0];

        $redTeam = null;
        foreach ($game->getTeams() as $team) {
            if ($team->getName() === "Red") $redTeam = $team;
        }

        TeamGameSystem::addScore($game->getId(), $redTeam->getId(), new Score(100));

        //再取得して更新されているか確認する
        $game = GameStore::getAll()[0];
        $redTeam = null;
        foreach ($game->getTeams() as $team) {
            if ($team->getName() === "Red") $redTeam = $team;
        }
        $this->assertEquals(100, $redTeam->getScore()->getValue());
    }

    public function testJoinGame() {
        $game = GameStore::getAll()[0];
        JoinGameService::execute("Steve", $game->getId(), null);

        $players = PlayerDataStore::getGamePlayers($game->getId());
        $this->assertCount(1, $players);

        $this->assertNotNull(PlayerDataStore::findByName("Steve")->getGameId());
    }
}