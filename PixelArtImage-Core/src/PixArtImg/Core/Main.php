<?php

namespace PixArtImg\Core;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener{
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}
	/**
	 * @priority LOWEST
	 */
	public function drawImage(DrawImageRequestEvent $event){
		// TODO
	}
}
