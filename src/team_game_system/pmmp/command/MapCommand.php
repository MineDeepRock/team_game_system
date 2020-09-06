<?php

namespace team_game_system\pmmp\command;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use team_game_system\pmmp\form\MapMenuForm;

class MapCommand extends Command
{
    public function __construct() {
        parent::__construct("map", "マップの設定", "/map");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if ($sender instanceof Player) {
            if (!$sender->isOp()) {
                $sender->sendMessage("権限が無いです");
                return;
            }
            $sender->sendForm(new MapMenuForm());
        }
    }
}