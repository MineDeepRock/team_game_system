# TeamGameSystem
２チーム以上のPVPゲーム作成を補助するプラグインです。
- 複数ゲームの同時進行
- チーム同士の攻撃キャンセル
- スコアの管理
- 時間制限の管理
- チーム配分
- 人数制限
- Minecraft内でのマップ作成とスポーン地点設定、その他マップ管理

# サンプル
[Qiitaの記事](https://qiita.com/suinua/items/d41309e2ec28893cae8a)  
[チームデスマッチ](https://github.com/suinua/TeamDeathMatch)


# 使い方

## マップの設定
コマンド`/map`で出てくるフォームで操作します。  

- map name  
識別に使われます。同じ名前は使用不可能です。

- map level name  
フォームを出したプレイヤーのLevelがマップのLevelになります。  

- spawn points group  
マップの`スポーン地点グループ`はチームのスポーン地点はと一致します。  
(スポーン地点グループはランダムで割り当てられる)  

## API
`Game`はIDとTYPEを持っています。  
IDはそれぞれユニークな物で、API側で指定します。  
TYPEは重複しても大丈夫な物で、ユーザーが指定します。  
TYPEは複数種類のゲームモード(チーデス、ドミネーション)を作るときに役立ちます。  
  
GameTypeListなどのクラスを作り管理することを推奨します。


### ゲームを作成
```php
use pocketmine\utils\TextFormat;use team_game_system\model\Game;
use team_game_system\model\Team;
use team_game_system\TeamGameSystem;

$teams = [
    Team::asNew("Red", TextFormat::RED),
    Team::asNew("Blue", TextFormat::BLUE),
    Team::asNew("Green", TextFormat::GREEN),
];
$map = TeamGameSystem::selectMap("map", $teams);
$game = Game::asNew(new \team_game_system\model\GameType("TeamDeathMatch"),$map, $teams);

TeamGameSystem::registerGame($game);
```

### ゲームに参加させる
```php
use team_game_system\TeamGameSystem;
$player = null;

//人数が一番少ないチームに参加
$games = TeamGameSystem::getAllGames();
$game = $games[array_rand($games)];
TeamGameSystem::joinGame($player, $game->getId());

//指定のチームに参加
$team = $game->getTeams()[array_rand($game->getTeams())];
TeamGameSystem::joinGame($player, $game->getId(), $team->getId());

//指定のチームに強制で参加
$team = $game->getTeams()[array_rand($game->getTeams())];
TeamGameSystem::joinGame($player, $game->getId(), $team->getId(), true);
```

### スコアを追加
```php
use team_game_system\model\Score;
use team_game_system\TeamGameSystem;

$playerData = TeamGameSystem::getPlayerData($player);
TeamGameSystem::addScore($playerData->getGameId(), $playerData->getTeamId(), new Score(10)); 
```

### ランダムでスポーン地点をセット
```php
use team_game_system\TeamGameSystem;

TeamGameSystem::setSpawnPoint($player);
```

## イベント一覧
### PlayerJoinedGameEvent
プレイヤーがゲームに参加したときに呼び出されます

### PlayerMovedGameEvent
プレイヤーがチームを移動したときに呼び出されます

### PlayerKilledPlayerEvent
プレイヤーが相手に倒されたときに呼び出されます

### AddedScoreEvent
スコアが追加されたときに呼び出されます

### PlayerQuitGameEvent
プレイヤーがゲームから抜けたときに呼び出されます

### StartedGameEvent
ゲームが開始されたときに呼び出されます

### UpdatedGameTimerEvent
ゲームの経過時間が更新されたときに呼び出されます

# 依存関係
[form_builder](https://github.com/MineDeepRock/form_builder)  
[slot_menu_system](https://github.com/MineDeepRock/slot_menu_system)  
↑２つを導入してください

# Composerで補完する
repositoriesに以下を追加
```json
{
  "type": "git",
  "name": "suinua/team_game_system",
  "url": "https://github.com/MineDeepRock/team_game_system"
}
```
requireに以下を追加
```json
"suinua/team_game_system": "dev-master",
```
