<?php

class DBProfilerQueryList extends ArrayList {

	protected $url = null;

	public function Link() {
		return Director::absoluteURL('/dev/profiler/'.$this->Sha1);
	}

 	public function setURL($url) {
		$this->url = $url;
	}

	public function getURL() {
		return $this->url;
	}

	public function getTotalTime() {
		$sum = 0.0;
		foreach($this->items as $item){
			$sum += $item->time;
		}
		return $sum;
	}

	public function getDuplicateCount() {
		$shas = array();
		foreach($this->items as $item) {
			$shas[] = $item->hash;
		}
		return $this->count()-count(array_unique($shas));
	}

	public function getDuplicateTime() {
		$history = array();
		$sum = 0;
		foreach($this->items as $item) {
			if(in_array($item->hash, $history)) {
				$sum += $item->time;
			} else {
				$history[] = $item->hash;
			}
		}
		return $sum;
	}
}