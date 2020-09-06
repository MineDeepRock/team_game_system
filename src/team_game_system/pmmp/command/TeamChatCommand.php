<?php


namespace team_game_system\pmmp\command;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use team_game_system\pmmp\service\SendTeamChatPMMPService;

class TeamChatCommand extends Command
{
    public function __construct() {
        parent::__construct("tc", "チームチャット", "/tc [message]");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if ($sender instanceof Player) {
            if (count($args) !== 1) {
                $sender->sendMessage($this->getUsage());
                return;
            }

            SendTeamChatPMMPService::execute($sender, $args[0]);
        }
    }
}