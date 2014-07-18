<?php

namespace PixartImg\Core;

use pocketmine\Player;
use pocketmine\task\PluginTask;
use pocketmine\network\protocol\RemovePlayerPacket;
use pocketmine\plugin\Plugin;

class DespawnPlayerTask extends PluginTask{
	private $eid;
	private $target;
	public function __construct(Plugin $plugin, $eid, Player $target){
		parent::__construct($plugin);
		$this->eid = $eid;
		$this->target = $target;
	}
	public function onRun($ticks){
		$pk = new RemovePlayerPacket;
		$pk->eid = $this->eid;
		$pk->clientID = 0;
		$this->target->dataPacket($pk);
	}
}
