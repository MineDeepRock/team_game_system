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

class TestGame extends TestCase
{
    public static function setUpBeforeClass(): void {
        $teams = [
            Team::asNew("Red", TextFormat::RED),
            Team::asNew("Blue", TextFormat::BLUE),
            Team::asNew("Green", TextFormat::GREEN),
        ];
        $map = TeamGameSystem::selectMap("map", $teams);
        $game = Game::asNew(new GameType("TeamDeathMatch"), $map, $teams);

        TeamGameSystem::registerGame($game);

        PlayerDataStore::add(new PlayerData("Steve1", null, null));
        PlayerDataStore::add(new PlayerData("Steve2", null, null));
        PlayerDataStore::add(new PlayerData("Steve3", null, null));
        PlayerDataStore::add(new PlayerData("Steve4", null, null));
        PlayerDataStore::add(new PlayerData("Steve5", null, null));
        PlayerDataStore::add(new PlayerData("Steve6", null, null));
        PlayerDataStore::add(new PlayerData("Steve7", null, null));
    }


    public function testRandomJoin() {
        $game = GameStore::getAll()[0];
        JoinGameService::execute("Steve1", $game->getId(), null);
        JoinGameService::execute("Steve2", $game->getId(), null);
        JoinGameService::execute("Steve3", $game->getId(), null);

        $players = PlayerDataStore::getGamePlayers($game->getId());
        $this->assertCount(3, $players);

        $this->assertNotNull(PlayerDataStore::findByName("Steve1")->getGameId());

        //均一にわかれているか
        $game = GameStore::getAll()[0];
        foreach ($game->getTeams() as $team) {
            $this->assertCount(1, TeamGameSystem::getTeamPlayersData($team->getId()));
        }
    }

    public function testJoinDesignatedTeam() {
        $game = GameStore::getAll()[0];
        $team = $game->getTeams()[1];
        $result = JoinGameService::execute("Steve4", $game->getId(), $team->getId());
        $this->assertTrue($result);
    }

    public function testJoinDesignatedTeamForce() {
        $game = GameStore::getAll()[0];
        $team = $game->getTeams()[1];
        $result = JoinGameService::execute("Steve5", $game->getId(), $team->getId(), true);
        $this->assertTrue($result);
    }

    public function testMoveTeam() {
        $game = GameStore::getAll()[0];
        $team = $game->getTeams()[0];
        JoinGameService::execute("Steve6", $game->getId(), $team->getId(), true);

        $team = $game->getTeams()[1];
        $result = MoveTeamService::execute("Steve6", $game->getId(), $team->getId());
        $this->assertFalse($result);
    }

    public function testMoveTeamForce() {
        $game = GameStore::getAll()[0];
        $team = $game->getTeams()[2];
        JoinGameService::execute("Steve7", $game->getId(), $team->getId(), true);

        $team = $game->getTeams()[1];
        $result = MoveTeamService::execute("Steve7", $game->getId(), $team->getId(), true);
        $this->assertTrue($result);
    }
}