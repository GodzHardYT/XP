<?php

namespace GodzHardYT\XP;

use GodzHardYT\XP\Commands\XPCommands;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase {

    public function onEnable() : void {
        $this->saveDefaultConfig();
        $this->getServer()->getCommandMap()->register("XPCommands", new XPCommands($this));
    }
}
