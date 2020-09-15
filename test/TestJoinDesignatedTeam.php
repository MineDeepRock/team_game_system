<?php


use PHPUnit\Framework\TestCase;
use pocketmine\utils\TextFormat;
use team_game_system\data_model\PlayerData;
use team_game_system\model\Game;
use team_game_system\model\GameType;
use team_game_system\model\Team;
use team_game_system\service\JoinGameService;
use team_game_system\store\GameStore;
use team_game_system\store\PlayerDataStore;
use team_game_system\TeamGameSystem;

class TestJoinDesignatedTeam extends TestCase
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
        PlayerDataStore::add(new PlayerData("JoinDesignatedTeam1", null, null));
        PlayerDataStore::add(new PlayerData("JoinDesignatedTeam2", null, null));
        JoinGameService::execute("JoinDesignatedTeam1", $game->getId(), null);
        JoinGameService::execute("JoinDesignatedTeam2", $game->getId(), null);

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
        PlayerDataStore::add(new PlayerData("JoinDesignatedTeam1", null, null));
        PlayerDataStore::add(new PlayerData("JoinDesignatedTeam2", null, null));
        JoinGameService::execute("JoinDesignatedTeam1", $game->getId(), null);
        JoinGameService::execute("JoinDesignatedTeam2", $game->getId(), null);

        return $game;
    }

    protected function tearDown(): void {
        PlayerDataStore::remove("JoinDesignatedTeam1");
        PlayerDataStore::remove("JoinDesignatedTeam2");
        PlayerDataStore::remove("JoinDesignatedTeam3");
        PlayerDataStore::remove("JoinDesignatedTeam4");

        GameStore::deleteAll();
    }

    public function testNormalSuccess() {
        $game = $this->setUpGame("JoinDesignatedTeam");
        PlayerDataStore::add(new PlayerData("JoinDesignatedTeam3", null, null));

        $team = $game->getTeams()[1];
        $result = JoinGameService::execute("JoinDesignatedTeam3", $game->getId(), $team->getId());
        $this->assertTrue($result);

        //ちゃんと参加しているか
        $playerData = PlayerDataStore::findByName("JoinDesignatedTeam3");
        $this->assertTrue($playerData->getTeamId()->equals($team->getId()));
    }

    //人数差の制限か設定されてない場合。どこでも入れる
    public function testNormalWithoutMaxPlayersDifference() {
        $game = $this->setUpGame("JoinDesignatedTeam");
        $team = $game->getTeams()[1];

        //[1]に参加させて人数差を+1する
        PlayerDataStore::add(new PlayerData("JoinDesignatedTeam3", null, null));
        $result = JoinGameService::execute("JoinDesignatedTeam3", $game->getId(), $team->getId());
        $this->assertTrue($result);

        //人数差が1のチームに参加しようとする
        PlayerDataStore::add(new PlayerData("JoinDesignatedTeam4", null, null));
        $result = JoinGameService::execute("JoinDesignatedTeam4", $game->getId(), $team->getId());
        $this->assertTrue($result);

        //ちゃんと参加しているか
        $playerData = PlayerDataStore::findByName("JoinDesignatedTeam3");
        $this->assertTrue($playerData->getTeamId()->equals($team->getId()));

        //ちゃんと参加しているか
        $playerData = PlayerDataStore::findByName("JoinDesignatedTeam4");
        $this->assertTrue($playerData->getTeamId()->equals($team->getId()));
    }

    ////人数差の制限か設定されている場合
    public function testNormalWithMaxPlayersDifference() {
        $game = $this->setUpGameWithMaxPlayersDifference("JoinDesignatedTeam", 1);
        $team = $game->getTeams()[1];

        //[1]に参加させて人数差を+1する
        PlayerDataStore::add(new PlayerData("JoinDesignatedTeam3", null, null));
        $result = JoinGameService::execute("JoinDesignatedTeam3", $game->getId(), $team->getId());
        $this->assertTrue($result);

        //人数差が1のチームに参加しようとする
        PlayerDataStore::add(new PlayerData("JoinDesignatedTeam4", null, null));
        $result = JoinGameService::execute("JoinDesignatedTeam4", $game->getId(), $team->getId());
        $this->assertFalse($result);

        //ちゃんと参加しているか
        $playerData = PlayerDataStore::findByName("JoinDesignatedTeam3");
        $this->assertTrue($playerData->getTeamId()->equals($team->getId()));

        //参加していないはず
        $playerData = PlayerDataStore::findByName("JoinDesignatedTeam4");
        $this->assertNull($playerData->getTeamId());
    }


    //人数差の制限か設定されているが、強制
    public function testNormalWithMaxPlayersDifferenceForce() {
        $game = $this->setUpGameWithMaxPlayersDifference("JoinDesignatedTeam", 1);

        //[1]に参加させて人数差を+1する
        PlayerDataStore::add(new PlayerData("JoinDesignatedTeam3", null, null));
        $team = $game->getTeams()[1];
        $result = JoinGameService::execute("JoinDesignatedTeam3", $game->getId(), $team->getId());
        $this->assertTrue($result);

        //人数差が1のチームに参加しようとする
        PlayerDataStore::add(new PlayerData("JoinDesignatedTeam4", null, null));
        $team = $game->getTeams()[1];
        $result = JoinGameService::execute("JoinDesignatedTeam4", $game->getId(), $team->getId(), true);
        $this->assertTrue($result);

        //ちゃんと参加しているか
        $playerData = PlayerDataStore::findByName("JoinDesignatedTeam3");
        $this->assertTrue($playerData->getTeamId()->equals($team->getId()));

        //ちゃんと参加しているか
        $playerData = PlayerDataStore::findByName("JoinDesignatedTeam4");
        $this->assertTrue($playerData->getTeamId()->equals($team->getId()));
    }
}