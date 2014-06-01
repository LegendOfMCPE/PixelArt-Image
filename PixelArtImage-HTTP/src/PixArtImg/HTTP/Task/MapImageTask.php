<?php

namespace PixArtImg\HTTP\Task;

use pocketmine\Player;

class MapImageTask extends Task{
	protected $lastPublish = 0xdeadc0de;
	protected $map = null;
	public function __construct($main, Player $player, $url, $callback){
		$this->main = $main;
		$this->player = $player;
		$this->url = $url;
		$this->callback = $callback;
	}
	public function publishProgress(){
		$perc = $this->stage * 33;
		if($this->stage === 2){
			$perc += 34 * ($this->maxProgress / $this->progress);
		}
		if($perc !== $this->lastPublish){
			$this->player->sendMessage("Image mapping ".$perc."% finished!");
			$this->lastPublish = $perc;
		}
	}
	public function onRuntime(){
		$this->stage = 0;
		switch(strtolower(array_slice(explode(".", $this->url), -1))){
			case "jpg":
			case "jpeg":
			case "jpe":
			case "jfif":
				$res = imagecreatefromjpeg($url);
				break;
			case "gif":
				$res = imagecreatefromgif($url);
				break;
			case "png":
				$res = imagecreatefrompng($url);
				break;
			default:
				$this->setResult("Unsupported image type");
				return;
		}
		$this->stage = 1;
		$width = imagesx($res);
		$height = imagesy($res);
		if(imagesx($res) >= 256 or imagesy($res) >= 128){
			$ratio = max(imagesx($res) / 256, imagesy($res) / 128);
			$new = imagecreate((int) (imagesx($res) / $ratio), (int) (imagesy($res) / $ratio));
			$failure = !imagecopyresized($new, $res, 0, 0, 0, 0, imagesx($new), imagesy($new), imagesx($res), imagesy($res));
			if($failure){
				$this->setResult("Failed resizing image.");
				return;
			}
			$res = $new;
		}
		$map = array();
		$this->progress = 0;
		$this->maxProgress = imagesx($res) * imagesy($res);
		$this->stage = 2;
		for($x = 0; $x < imagesx($res); $x++){
			$map[$x] = [];
			for($y = 0; $y < imagesy($res); $y++){
				$map[$x][$y] = imagecolorat($res, $x, $y);
			}
		}
		$this->map = $map;
	}
	public function onPostRun(){
		call_user_func($this->callback, $this->map === null ? $this->getResult():$this->map, $this->player);
	}
}
