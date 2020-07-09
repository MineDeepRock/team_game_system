<?php


use PHPUnit\Framework\TestCase;
use pocketmine\math\Vector3;
use pocketmine\utils\Color;
use team_game_system\adapter\MapJsonAdapter;
use team_game_system\model\Map;
use team_game_system\model\SpawnPoint;
use team_game_system\model\Team;

class TestTeamGameSystem extends TestCase
{
    public function testCreateMap() {
        $redTeam = Team::asNew("Red", new Color(255, 0, 0));
        $blueTeam = Team::asNew("Blue", new Color(0, 0, 255));
        $green = Team::asNew("Blue", new Color(0, 255, 0));


        $map = new Map("map", "map", [
            new SpawnPoint($redTeam->getId(), new Vector3(1, 0, 0)),
            new SpawnPoint($redTeam->getId(), new Vector3(2, 0, 0)),
            new SpawnPoint($redTeam->getId(), new Vector3(3, 0, 0)),

            new SpawnPoint($blueTeam->getId(), new Vector3(0, 1, 0)),
            new SpawnPoint($blueTeam->getId(), new Vector3(0, 2, 0)),
            new SpawnPoint($blueTeam->getId(), new Vector3(0, 3, 0)),

            new SpawnPoint($green->getId(), new Vector3(0, 0, 1)),
            new SpawnPoint($green->getId(), new Vector3(0, 0, 2)),
            new SpawnPoint($green->getId(), new Vector3(0, 0, 3)),
        ]);

        \team_game_system\service\CreateMapService::execute($map);

        $this->assertEquals(true, file_exists(\team_game_system\DataFolderPath::MAP . "map.json"));
    }
}