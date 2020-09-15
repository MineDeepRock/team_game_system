<?php


use PHPUnit\Framework\TestCase;
use pocketmine\utils\TextFormat;
use team_game_system\data_model\PlayerData;
use team_game_system\model\Game;
use team_game_system\model\GameType;
use team_game_system\model\Team;
use team_game_system\service\JoinGameService;
use team_game_system\service\MoveTeamService;
use team_game_system\store\GameStore;
use team_game_system\store\PlayerDataStore;
use team_game_system\TeamGameSystem;

class TestMoveTeam extends TestCase
{
    private function setUpGame(string $gameType): Game {
        $teams = [
            Team::asNew("Red", TextFormat::RED),
            Team::asNew("Blue", TextFormat::BLUE),
        ];
        $map = TeamGameSystem::selectMap("two_team", $teams);
        $game = Game::asNew(new GameType($gameType), $map, $teams);
        TeamGameSystem::registerGame($game);

        //均一に別れさせる
        PlayerDataStore::add(new PlayerData("MoveTeam1", null, null));
        PlayerDataStore::add(new PlayerData("MoveTeam2", null, null));
        JoinGameService::execute("MoveTeam1", $game->getId(), null);
        JoinGameService::execute("MoveTeam2", $game->getId(), null);

        return $game;
    }

    private function setUpGameWithMaxPlayersDifference(string $gameType, int $count): Game {
        $teams = [
            Team::asNew("Red", TextFormat::RED),
            Team::asNew("Blue", TextFormat::BLUE),
        ];
        $map = TeamGameSystem::selectMap("two_team", $teams);
        $game = Game::asNew(new GameType($gameType), $map, $teams);
        $game->setMaxPlayersDifference($count);
        TeamGameSystem::registerGame($game);

        //均一に別れさせる
        PlayerDataStore::add(new PlayerData("MoveTeam1", null, null));
        PlayerDataStore::add(new PlayerData("MoveTeam2", null, null));
        JoinGameService::execute("MoveTeam1", $game->getId(), null);
        JoinGameService::execute("MoveTeam2", $game->getId(), null);

        return $game;
    }

    protected function tearDown(): void {
        PlayerDataStore::remove("MoveTeam1");
        PlayerDataStore::remove("MoveTeam2");
        PlayerDataStore::remove("MoveTeam3");
        PlayerDataStore::remove("MoveTeam4");

        GameStore::deleteAll();
    }

    public function testNormal() {
        $game = $this->setUpGame("MoveTeam");
        PlayerDataStore::add(new PlayerData("MoveTeam3", null, null));
        $joinResult = JoinGameService::execute("MoveTeam3", $game->getId(), $game->getTeams()[0]->getId());
        $this->assertTrue($joinResult);

        $moveResult = MoveTeamService::execute("MoveTeam3", $game->getId(), $game->getTeams()[1]->getId());
        $this->assertTrue($moveResult);
    }

    public function testMoveSameTeam() {
        $game = $this->setUpGame("MoveTeam");
        PlayerDataStore::add(new PlayerData("MoveTeam3", null, null));
        $joinResult = JoinGameService::execute("MoveTeam3", $game->getId(), $game->getTeams()[0]->getId());
        $this->assertTrue($joinResult);

        $moveResult = MoveTeamService::execute("MoveTeam3", $game->getId(), $game->getTeams()[0]->getId());
        $this->assertFalse($moveResult);
    }

    public function testMoveWithMaxPlayersDifference() {
        $game = $this->setUpGameWithMaxPlayersDifference("MoveTeam", 1);
        PlayerDataStore::add(new PlayerData("MoveTeam3", null, null));
        PlayerDataStore::add(new PlayerData("MoveTeam4", null, null));
        $joinResult = JoinGameService::execute("MoveTeam3", $game->getId(), $game->getTeams()[0]->getId());
        $this->assertTrue($joinResult);
        $joinResult = JoinGameService::execute("MoveTeam4", $game->getId(), $game->getTeams()[1]->getId());
        $this->assertTrue($joinResult);

        $moveResult = MoveTeamService::execute("MoveTeam3", $game->getId(), $game->getTeams()[1]->getId());
        $this->assertFalse($moveResult);
    }

    public function testMoveWithMaxPlayersDifferenceForce() {
        $game = $this->setUpGameWithMaxPlayersDifference("MoveTeam", 1);
        PlayerDataStore::add(new PlayerData("MoveTeam3", null, null));
        PlayerDataStore::add(new PlayerData("MoveTeam4", null, null));
        $joinResult = JoinGameService::execute("MoveTeam3", $game->getId(), $game->getTeams()[0]->getId());
        $this->assertTrue($joinResult);
        $joinResult = JoinGameService::execute("MoveTeam4", $game->getId(), $game->getTeams()[1]->getId());
        $this->assertTrue($joinResult);

        $moveResult = MoveTeamService::execute("MoveTeam3", $game->getId(), $game->getTeams()[1]->getId(), true);
        $this->assertTrue($moveResult);
    }

}