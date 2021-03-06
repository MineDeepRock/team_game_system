# TeamGameSystem
２チーム以上のPVPゲーム作成を補助するプラグインです。
- 複数ゲームの同時進行
- チーム同士の攻撃キャンセル
- スコアの管理
- 時間制限の管理
- チーム配分
- 人数制限
- 人数差制限
- Minecraft内でのマップ作成とスポーン地点設定、その他マップ管理
- チームチャット`/tc [message]`

# サンプル
[Qiitaの記事](https://qiita.com/suinua/items/d41309e2ec28893cae8a)  
[チームデスマッチ](https://github.com/suinua/TeamDeathMatch)


# マップの設定
コマンド`/map`で出てくるフォームで操作します。  

- map name  
識別に使われます。同じ名前は使用不可能です。

- map level name  
フォームを出したプレイヤーのLevelがマップのLevelになります。  

- spawn points group  
マップの`スポーン地点グループ`はチームのスポーン地点はと一致します。  
(スポーン地点グループはランダムで割り当てられる)  

# API
`Game`はIDとTYPEを持っています。  
IDはそれぞれユニークな物で、API側で指定します。  
TYPEは重複しても大丈夫な物で、ユーザーが指定します。  
TYPEは複数種類のゲームモード(チーデス、ドミネーション)を作るときに役立ちます。  
  
GameTypeListなどのクラスを作り管理することを推奨します。

## Mapに関するAPI

### マップを選択
```php
use pocketmine\utils\TextFormat;use team_game_system\TeamGameSystem;
use team_game_system\model\Team;

$teams = [
    Team::asNew("RED",TextFormat::RED),
    Team::asNew("Blue",TextFormat::BLUE),
];

$map = TeamGameSystem::selectMap("map_name", $teams);
```

## ゲームを操作するAPI

### ゲームを作成
```php
use pocketmine\utils\TextFormat;
use team_game_system\model\Game;
use team_game_system\model\GameType
use team_game_system\model\Team;

$teams = [
    Team::asNew("RED",TextFormat::RED),
    Team::asNew("Blue",TextFormat::BLUE),
];

$game = Game::asNew(new GameType("TDM", $map, $teams));

//↓設定しなくてもOK
$game->setMaxPlayersCount(30);//試合に参加できる最大人数
$game->setMaxPlayersDifference(1);//チーム間の人数差制限
$game->setMaxScore(50);//勝利判定スコア
$game->setTimeLimit(600);//時間制限(秒)
```
### ゲームを登録
```php
use team_game_system\TeamGameSystem;

TeamGameSystem::registerGame($game);
```
### ゲームをスタート
```php
use team_game_system\TeamGameSystem;

TeamGameSystem::startGame($scheduler, $gameId);
```
### ゲームを終了
```php
use team_game_system\TeamGameSystem;

TeamGameSystem::finishedGame($gameId);
```

## ゲームデータを取得するAPI

### すべてのゲームを取得
```php
use team_game_system\TeamGameSystem;

TeamGameSystem::getAllGames();
```
### IDからゲームを取得
```php
use team_game_system\TeamGameSystem;

TeamGameSystem::getGame($gameId);
```
### TYPEからゲームを取得
```php
use team_game_system\model\GameType;
use team_game_system\TeamGameSystem;

TeamGameSystem::findGamesByType(new GameType("TDM"));
```
### チームを取得
```php
use team_game_system\model\GameType;
use team_game_system\TeamGameSystem;

TeamGameSystem::getTeam($gameId, $teamId);
```

## プレイヤーに関するAPI
### ゲームに参加
```php
use team_game_system\TeamGameSystem;

TeamGameSystem::joinGame($plyaer, $gameId);
```
### チームを移動
```php
use team_game_system\TeamGameSystem;

TeamGameSystem::joinGame($plyaer, $gameId);
```
### ゲームから抜ける
```php
use team_game_system\TeamGameSystem;

TeamGameSystem::quitGame($plyaer);
```

## 試合に関するAPI
### スコアを追加
```php
use team_game_system\model\Score;
use team_game_system\TeamGameSystem;

TeamGameSystem::addScore($gameId,$teamId,new Score(1));
```
### マップに登録されたスポーン地点を、ランダムにセット
```php
use team_game_system\TeamGameSystem;

TeamGameSystem::setSpawnPoint($player);
```

## プレイヤーデータに関するAPI
### 名前からプレイヤーデータを取得
```php
use team_game_system\TeamGameSystem;

TeamGameSystem::getPlayerData($player);
```
### 特定の試合に参加しているプレイヤーデータを取得
```php
use team_game_system\TeamGameSystem;

TeamGameSystem::getGamePlayersData($gameId);
```
### 特定のチームに参加しているプレイヤーデータを取得
```php
use team_game_system\TeamGameSystem;

TeamGameSystem::getTeamPlayersData($teamId);
```

# イベント一覧
## PlayerJoinedGameEvent
プレイヤーがゲームに参加したときに呼び出されます

## PlayerMovedGameEvent
プレイヤーがチームを移動したときに呼び出されます

## PlayerKilledPlayerEvent
プレイヤーが相手に倒されたときに呼び出されます

## AddedScoreEvent
スコアが追加されたときに呼び出されます

## PlayerQuitGameEvent
プレイヤーがゲームから抜けたときに呼び出されます

## StartedGameEvent
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
  "name": "mine_deep_rock/team_game_system",
  "url": "https://github.com/MineDeepRock/team_game_system"
}
```
requireに以下を追加
```json
"mine_deep_rock/team_game_system": "dev-master",
```
