<?php

namespace PixArtImg\Core;

use pocketmine\entity\Entity;
use pocketmine\event\Listener;
use pocketmine\network\protocol\AddPlayerPacket;
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
		$tag = [];
		$map = $event->getMapped();
		foreach($map as $x => $column){
			foreach($column as $y => $col){
				if(!isset($tag[$y])){
					$tag[$y] = "";
				}
				$tag[$y] .= self::chrToColStr($col);
			}
		}
		$pk = new AddPlayerPacket;
		$pk->clientID = 0;
		$pk->username = implode("\n", $tag);
		$pk->eid = Entity::$entityCount++;
		$vectors = $player->getDirectionVector()->multiply(16); // distance relative to image size?
		$pk->x = $vectors->x;
		$pk->y = $vectors->y;
		$pk->z = $vectors->z;
		$pk->pitch = 0;
		$pk->yaw = 0;
		$pk->unknown1 = 0;
		$pk->unknown2 = 0;
		$pk->metadata = 0;
		$p->dataPacket($pk);
		$p->sendMessage("The image has produced in front of you.");
		$this->getServer()->getScheduler()->scheduleDelayedTask(new DespawnPlayerTask($this, $pk->eid, $p), $event->getTicks());
	}
	public function onQuit(PlayerQuitEvent $event){
		if(isset($this->sessions[$event->getPlayer()])){
			unset($this->sessions[$event->getPlayer()]);
		}
	}
	public function chrToColStr($col){
		$r = ($col >> 16) & 0xFF;
		$g = ($col >> 8) & 0xFF;
		$b = $col & 0xFF;
		// mode: B&W
		$b_w = ($r + $g + $b) / 3;
		// ascending order
		if($b_w <= 0){
			return " ";
		}
		if($b_w <= 0xb1a6b1a6){ // leet: blahblah
			return "blahblah";
		}
		if($b_w <= 0xFF){
			return "???"; // a totally full right character
		}
	}
}
