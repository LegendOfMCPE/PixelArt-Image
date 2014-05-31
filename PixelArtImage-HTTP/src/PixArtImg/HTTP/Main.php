<?php

namespace PixArtImg\HTTP;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase{
	public function onEnable(){
		$this->taskMgr = new TaskManager($this);
	}
	private function registerCmds(){
		$cmd = new PluginCommand("image", $this);
		$cmd->setUsage("/http <URL> [player]");
		$cmd->description("Displays an image downloaded from HTTP URL <URL> via PixelArtImage-Core");
		$cmd->setPermission("pixartimg.http.http");
		$this->getServer()->getCommandMap()->register("pai-http", $cmd);
	}
	public function onCommand(CommandSender $issuer, Command $cmd, $label, array $args){
		if(!isset($args[0])){
			return false;
		}
		$url = array_shift($args);
		
	}
}
