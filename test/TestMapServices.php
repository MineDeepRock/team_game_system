<?php


use PHPUnit\Framework\TestCase;
use pocketmine\math\Vector3;
use team_game_system\DataFolderPath;
use team_game_system\model\Map;
use team_game_system\model\SpawnPoint;
use team_game_system\service\AddSpawnPointService;
use team_game_system\service\CreateMapService;
use team_game_system\service\RemoveSpawnPointService;
use team_game_system\store\MapsStore;

class TestMapServices extends TestCase
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

        $this->assertCount(3, MapsStore::findByName("map")->getSpawnPoints());
        $this->assertEquals(true, file_exists(DataFolderPath::MAP . "map.json"));
    }

    public function testAddSpawnPoint() {
        $map = MapsStore::findByName("map");
        AddSpawnPointService::execute($map, 0, new SpawnPoint(new Vector3(4, 0, 0)));

        $this->assertCount(4, MapsStore::findByName("map")->getSpawnPoints()[0]);
    }

    public function testRemoveSpawnPoint() {
        $map = MapsStore::findByName("map");
        RemoveSpawnPointService::execute($map, 0, new SpawnPoint(new Vector3(4, 0, 0)));

        $this->assertCount(3, MapsStore::findByName("map")->getSpawnPoints()[0]);
    }
}