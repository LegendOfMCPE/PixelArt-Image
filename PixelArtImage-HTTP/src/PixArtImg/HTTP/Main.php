<?php

namespace PixArtImg\HTTP;

use pocketmine\Player;
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
		if(!($issuer instanceof Player)){
			$issuer->sendMessage("Please run this command in-game.");
			return true;
		}
		$url = array_shift($args);
		if(substr($url, 0, 7) !== "http://"){
			$issuer->sendMessage("Only images from the internet are allowed. Please start your URL with \"http://\".");
			return true;
		}
		$this->taskMgr->schedule(new MapImageTask($this, $issuer, $url, array($this, "showMap")));
	}
	public function showMap($result, Player $player){
		if(!is_array($result)){
			$player->sendMessage("Failed mapping the requested image. Reason: $result");
		}
		$this->getServer()->getPluginManager()->callEvent(new DrawImageRequestEvent($result, $player));
	}
}
