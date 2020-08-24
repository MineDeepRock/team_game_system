<?php

namespace team_game_system;


use pocketmine\plugin\PluginBase;
use team_game_system\pmmp\command\MapCommand;
use team_game_system\pmmp\listener\TeamGameListener;

class Main extends PluginBase
{
    public function onEnable() {
        DataFolderPath::init($this->getDataFolder());
        $this->getServer()->getCommandMap()->register("map", new MapCommand());
        $this->getServer()->getPluginManager()->registerEvents(new TeamGameListener(), $this);
    }
}