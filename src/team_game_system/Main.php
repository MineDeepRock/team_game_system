<?php

namespace team_game_system;


use pocketmine\plugin\PluginBase;
use team_game_system\listener\TeamGameListener;
use team_game_system\pmmp\command\MapCommand;

class Main extends PluginBase
{
    public function onEnable() {
        $this->getServer()->getCommandMap()->register("map", new MapCommand());
        $this->getServer()->getPluginManager()->registerEvents(new TeamGameListener(), $this);
    }
}