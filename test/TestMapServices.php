<?php


use PHPUnit\Framework\TestCase;
use pocketmine\math\Vector3;
use team_game_system\DataFolderPath;
use team_game_system\model\Map;
use team_game_system\model\SpawnPoint;
use team_game_system\model\SpawnPointsGroup;
use team_game_system\service\AddSpawnPointService;
use team_game_system\service\AddSpawnPointsGroupService;
use team_game_system\service\CreateMapService;
use team_game_system\service\RemoveSpawnPointService;
use team_game_system\service\RemoveSpawnPointsGroupService;
use team_game_system\store\MapsStore;

class TestMapServices extends TestCase
{
    public static function setUpBeforeClass(): void {
        $map = new Map("map", "map", [
            new SpawnPointsGroup([
                new SpawnPoint(new Vector3(1, 0, 0)),
                new SpawnPoint(new Vector3(2, 0, 0)),
                new SpawnPoint(new Vector3(3, 0, 0)),
            ]),
            new SpawnPointsGroup([
                new SpawnPoint(new Vector3(0, 1, 0)),
                new SpawnPoint(new Vector3(0, 2, 0)),
                new SpawnPoint(new Vector3(0, 3, 0)),
            ]),
            new SpawnPointsGroup([
                new SpawnPoint(new Vector3(0, 0, 1)),
                new SpawnPoint(new Vector3(0, 0, 2)),
                new SpawnPoint(new Vector3(0, 0, 3)),
            ]),
        ]);

        CreateMapService::execute($map);
    }

    public function testAddSpawnPoint() {
        $map = MapsStore::findByName("map");
        AddSpawnPointService::execute($map, 0, new SpawnPoint(new Vector3(4, 0, 0)));

        $this->assertCount(4, MapsStore::findByName("map")->getSpawnPointGroups()[0]->getSpawnPoints());
    }

    public function testRemoveSpawnPoint() {
        $map = MapsStore::findByName("map");
        RemoveSpawnPointService::execute($map, 1, new SpawnPoint(new Vector3(0, 2, 0)));

        $this->assertCount(2, MapsStore::findByName("map")->getSpawnPointGroups()[1]->getSpawnPoints());
    }

    public function testAddSpawnPointsGroup() {
        $map = MapsStore::findByName("map");
        AddSpawnPointsGroupService::execute($map);

        $this->assertCount(4, MapsStore::findByName("map")->getSpawnPointGroups());
    }

    public function testRemoveSpawnPointsGroup() {
        $map = MapsStore::findByName("map");
        RemoveSpawnPointsGroupService::execute($map, 0);

        $this->assertCount(3, MapsStore::findByName("map")->getSpawnPointGroups());
    }
}