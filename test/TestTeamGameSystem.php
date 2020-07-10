<?php


use PHPUnit\Framework\TestCase;
use pocketmine\math\Vector3;
use pocketmine\utils\Color;
use team_game_system\DataFolderPath;
use team_game_system\model\Game;
use team_game_system\model\Map;
use team_game_system\model\Score;
use team_game_system\model\SpawnPoint;
use team_game_system\model\Team;
use team_game_system\service\CreateMapService;
use team_game_system\store\GameStore;
use team_game_system\TeamGameSystem;

class TestTeamGameSystem extends TestCase
{
    public function testCreateMap() {
        $map = new Map("map", "map", [
            [
                new SpawnPoint(new Vector3(1, 0, 0)),
                new SpawnPoint(new Vector3(2, 0, 0)),
                new SpawnPoint(new Vector3(3, 0, 0)),
            ],
            [
                new SpawnPoint(new Vector3(0, 1, 0)),
                new SpawnPoint(new Vector3(0, 2, 0)),
                new SpawnPoint(new Vector3(0, 3, 0)),
            ],
            [
                new SpawnPoint(new Vector3(0, 0, 1)),
                new SpawnPoint(new Vector3(0, 0, 2)),
                new SpawnPoint(new Vector3(0, 0, 3)),
            ],
        ]);

        CreateMapService::execute($map);

        $this->assertCount(3, \team_game_system\service\LoadMapService::findByName("map")->getSpawnPoints());
        $this->assertEquals(true, file_exists(DataFolderPath::MAP . "map.json"));
    }

    public function testCreateGame() {
        $teams = [
            Team::asNew("Red", new Color(255, 0, 0)),
            Team::asNew("Blue", new Color(0, 0, 255)),
            Team::asNew("Green", new Color(0, 255, 0)),
        ];
        $map = TeamGameSystem::selectMap("map", $teams);
        $game = Game::asNew($map, $teams);

        TeamGameSystem::createGame($game);

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
}