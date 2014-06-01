<?php

namespace PixArtImg\Core;

use pocketmine\Player;
use pocketmine\event\Cancellable;
use pocketmine\event\player\PlayerEvent;

class DrawImageRequestEvent extends PlayerEvent implements Cancellable{
	public static $handlerList = null;
	public function __construct(array $mappedImage, Player $player){
		$this->player = $player;
		$this->mapped = $mapped;
	}
	public function getMapped(){
		return $this->mapped;
	}
}
