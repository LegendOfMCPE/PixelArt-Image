<?php

namespace PixArtImg\Core;

use pocketmine\entity\Entity;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener{
	private $sessions = [];
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}
	/**
	 * @priority LOWEST
	 */
	public function drawImage(DrawImageRequestEvent $event){
		if(@$this->sessions[$event->getPlayer()] === true){
			$event->setCancelled(true);
			return;
		}
		$p->sendMessage("Creating PixelArt image...");
		$pk = new AddPlayerPacket;
		$pk->clientID = 0;
		$pk->username = $tag;
		$pk->eid = Entity::$entityCount++;
		$vectors = $player->getDirectionVector()->multiply(8); // distance configurable?
		$pk->x = $vectors->x;
		$pk->y = $vectors->y;
		$pk->z = $vectors->z;
		$pk->pitch = 0;
		$pk->yaw = 0;
		$p->sendMessage("The image has produced in front of you.");
	}
	public function onQuit(PlayerQuitEvent $event){
		if(isset($this->sessions[$event->getPlayer()])){
			unset($this->sessions[$event->getPlayer()]);
		}
	}
}
