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


class TestJoinRandomTeam  extends TestCase
{
    private function setUpTwoGame(string $gameType):Game {
        $teams = [
            Team::asNew("Red", TextFormat::RED),
            Team::asNew("Blue", TextFormat::BLUE),
        ];
        $map = TeamGameSystem::selectMap("two_team", $teams);
        $game = Game::asNew(new GameType($gameType), $map, $teams);
        TeamGameSystem::registerGame($game);

        return $game;
    }

    public function test() {
        $game = $this->setUpTwoGame("RandomJoin");

        PlayerDataStore::add(new PlayerData("RandomJoin1", null, null));
        PlayerDataStore::add(new PlayerData("RandomJoin2", null, null));
        JoinGameService::execute("RandomJoin1", $game->getId(), null);
        JoinGameService::execute("RandomJoin2", $game->getId(), null);

        $players = PlayerDataStore::getGamePlayers($game->getId());
        $this->assertCount(2, $players);

        //GameIDが更新されているか
        $this->assertNotNull(PlayerDataStore::findByName("RandomJoin1")->getGameId());
        $this->assertNotNull(PlayerDataStore::findByName("RandomJoin2")->getGameId());

        //均一にわかれているか
        $game = GameStore::findById($game->getId());
        foreach ($game->getTeams() as $team) {
            $this->assertCount(1, TeamGameSystem::getTeamPlayersData($team->getId()));
        }
    }
}