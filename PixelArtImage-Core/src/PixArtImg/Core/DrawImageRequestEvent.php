<?php

namespace PixArtImg\Core;

use pocketmine\event\Cancellable;
use pocketmine\event\Event;

class DrawImageRequestEvent extends Event implements Cancellable{
	public static $handlerList = null;
}
