<?php

namespace PixArtImg\HTTP\Task;

use pocketmine\scheduler\PluginTask;

class TaskManager extends PluginTask{
	public function __construct($main){
		$this->main = $main;
	}
	public function schedule(Task $task){
		$task->mgr($this);
		$this->main->getServer()->getScheduler()->scheduleAsyncTask($task);
	}
	public function onRun($ticks){
		if($ticks % 60 === 0){
			foreach($this->tasks as $task){
				$task->publishProgress();
			}
		}
	}
	public function onCompleted(Task $task){
		unset($this->tasks[array_search($task, $this->tasks)]);
		$this->tasks = array_values($this->tasks);
	}
}
