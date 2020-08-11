<?php

namespace team_game_system\pmmp\listener;


use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\Player;
use team_game_system\data_model\PlayerData;
use team_game_system\pmmp\event\PlayerKilledPlayerEvent;
use team_game_system\pmmp\service\QuitGamePMMPService;
use team_game_system\service\QuitGameService;
use team_game_system\store\PlayerDataStore;

class TeamGameListener implements Listener
{
    /**
     * @param PlayerJoinEvent $event
     * @priority HIGH
     */
    public function onJoin(PlayerJoinEvent $event) {
        $player = $event->getPlayer();
        PlayerDataStore::add(new PlayerData($player->getName(), null, null));
    }

    public function onQuit(PlayerQuitEvent $event) {
        $player = $event->getPlayer();
        $playerData = PlayerDataStore::findByName($player->getName());
        QuitGameService::execute($player->getName());
        QuitGamePMMPService::execute($player, $playerData->getGameId(), $playerData->getTeamId());
    }

    public function onPlayerAttackPlayer(EntityDamageByEntityEvent $event): void {
        $attacker = $event->getDamager();
        $target = $event->getEntity();

        if ($attacker instanceof Player && $target instanceof Player) {
            $attackerData = PlayerDataStore::findByName($attacker->getName());
            $targetData = PlayerDataStore::findByName($target->getName());

            if ($attackerData->getTeamId() === null || $targetData->getTeamId() === null) {
                return;
            }
            if ($attackerData->getTeamId()->equals($targetData->getTeamId())) {
                $event->setCancelled();
            }
        }
    }


    public function onPlayerKilledPlayer(PlayerDeathEvent $event) {
        $target = $event->getPlayer();
        $cause = $target->getLastDamageCause();
        if ($cause instanceof EntityDamageByEntityEvent) {
            $attacker = $cause->getDamager();
            if ($attacker instanceof Player) {
                $playerKilledPlayerEvent = new PlayerKilledPlayerEvent($attacker, $target);
                $playerKilledPlayerEvent->call();
            }
        }
    }
}