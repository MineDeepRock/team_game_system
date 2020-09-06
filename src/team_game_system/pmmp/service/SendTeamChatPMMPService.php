<?php


namespace team_game_system\pmmp\service;


use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use team_game_system\service\FindTeamService;
use team_game_system\store\PlayerDataStore;

class SendTeamChatPMMPService
{
    static function execute(Player $player, string $message): void {
        $playerData = PlayerDataStore::findByName($player->getName());
        if ($playerData->getGameId() === null) {
            $player->sendMessage("ゲームに参加していません");
            return;
        }

        $teamPlayersData = PlayerDataStore::getTeamPlayers($playerData->getTeamId());
        $team = FindTeamService::execute($playerData->getGameId(), $playerData->getTeamId());

        foreach ($teamPlayersData as $teamPlayerData) {
            $teamPlayer = Server::getInstance()->getPlayer($teamPlayerData->getName());

            if ($teamPlayer === null) continue;
            if (!$teamPlayer->isOnline()) continue;

            $teamPlayer->sendMessage($team->getTeamColorFormat() . "[tc]{$player->getName()}: " . TextFormat::RESET . $message);
        }
    }
}