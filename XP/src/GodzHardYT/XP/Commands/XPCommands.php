<?php

namespace GodzHardYT\XP\Commands;

use GodzHardYT\XP\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\plugin\Plugin;

class XPCommands extends Command implements PluginIdentifiableCommand {

    private $plugin;

    public function __construct(Main $main) {
        parent::__construct("xp", "Edit xp player", "§cUsage: /xp");
        $this->plugin = $main;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if ($sender->hasPermission($this->plugin->getConfig()->get("permission-command"))) {
            if (!isset($args[0])) {
                $sender->sendMessage($this->plugin->getConfig()->get("usage-command"));
                return false;
            }
            if (!isset($args[1])) {
                $sender->sendMessage($this->plugin->getConfig()->get("usage-command"));
                return false;
            }
            if (!isset($args[2])) {
                $sender->sendMessage($this->plugin->getConfig()->get("usage-command"));
                return false;
            }
            if ($args[0]) {
                switch (strtolower($args[0])) {
                    case 'add':
                        $target = $this->plugin->getServer()->getPlayer($args[1]);
                        if ($target->isOnline()) {
                            $amount = $args[2];
                            $target->addXpLevels((int)$amount, true);
                            $sender->sendMessage(str_replace(["%amount%", "%target%"], [$amount, $target->getName()], $this->plugin->getConfig()->get("sender-addxp")));
                            $target->sendMessage(str_replace(["%amount%", "%sender%"], [$amount, $sender->getName()], $this->plugin->getConfig()->get("target-receivexp")));
                        } else {
                            $sender->sendMessage($this->plugin->getConfig()->get("player-not-online"));
                        }
                        break;
                    case 'remove':
                        $target = $this->plugin->getServer()->getPlayer($args[1]);
                        if ($target->isOnline()) {
                            $amount = $args[2];
                            $target->subtractXpLevels((int)$amount);
                            $sender->sendMessage(str_replace(["%amount%", "%target%"], [$amount, $target->getName()], $this->plugin->getConfig()->get("sender-removexp")));
                            $target->sendMessage(str_replace(["%amount%", "%sender%"], [$amount, $sender->getName()], $this->plugin->getConfig()->get("target-removedxp")));
                        } else {
                            $sender->sendMessage($this->plugin->getConfig()->get("player-not-online"));
                        }
                        break;
                }
            }
        } else {
            $sender->sendMessage($this->plugin->getConfig()->get("no-permission"));
            return false;
        }
        return false;
    }

    public function getPlugin(): Plugin {
        return $this->plugin;
    }

}