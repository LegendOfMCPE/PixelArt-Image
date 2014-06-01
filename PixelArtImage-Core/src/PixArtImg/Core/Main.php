<?php

namespace PixArtImg\Core;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener{
	private $sessions = [];
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}
	/**
	 * @priority LOWEST
	 * @ignoreCancelled false
	 */
	public function drawImage(DrawImageRequestEvent $event){
		if(@$this->sessions[$event->getPlayer()] === true){
			$event->setCancelled(true);
			return;
		}
		$p = $event->getPlayer();
		$p->sendMessage("Creating PixelArt image...");
		$p->sendMessage("The image is produced where the sun rises. Look at that direction!");
		$z = $p->z - 128;
	}
	public function onQuit(PlayerQuitEvent $event){
		if(isset($this->sessions[$event->getPlayer()])){
			unset($this->sessions[$event->getPlayer()]);
		}
	}
}
