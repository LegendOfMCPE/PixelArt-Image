<?php

namespace PixArtImg\HTTP\Task;

use pocketmine\scheduler\AsyncTask;

abstract class Task extends AsyncTask{
	public abstract function publishProgress();
	public function mgr(TaskManager $mgr){
		$this->mgr = $mgr;
		$this->onPreRun();
	}
	public function onRun(){
		$this->onRuntime();
		$this->mgr->onCompleted($this);
		$this->onPostRun();
	}
	protected function onPreRun(){
	}
	public abstract function onRuntime();
	protected function onPostRun(){
	}
}
