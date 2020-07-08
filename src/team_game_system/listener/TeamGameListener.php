<?php

namespace team_game_system\listener;


use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\Player;
use team_game_system\pmmp\event\PlayerKilledPlayerEvent;
use team_game_system\store\PlayerDataStore;

class TeamGameListener implements Listener
{
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