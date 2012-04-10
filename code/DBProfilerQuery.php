<?php

class DBProfilerQuery extends ViewableData {

	public $type = null;

	protected $duplicates = 0;

	public function canView() {
		return true;
	}

	public function getTime() {
		return sprintf("%0.1f", $this->time);
	}

	public function getBackgroundColor() {
		return substr($this->hash,0,6);
	}

	/**
	 * Get a black or white hex color code that would be contrasty against the
	 * background color
	 * 
	 * @return string
	 */
	public function getColor() {
		$tot = 0;
		for($x=0; $x<3; $x++) {
			$tot += hexdec(substr($this->getBackgroundColor(), (2*$x), 2));
		}
		return ($tot/3<128)?'fff':'000';
	}

	public function getSha1() {
		return $this->hash;
	}

	public function getQuerySummary() {
		return substr($this->query,0,80);
	}

	public function getQuery() {
		return $this->query;
	}

	public function getType() {
		return $this->type;
	}
	
	public function getDuplicates() {
		return $this->duplicates;
	}
}