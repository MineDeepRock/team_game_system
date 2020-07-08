<?php

namespace team_game_system;


use pocketmine\plugin\PluginBase;
use team_game_system\listener\TeamGameListener;

class Main extends PluginBase
{
    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents(new TeamGameListener(), $this);
    }
}