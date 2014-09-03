<?php

class DBProfilerQuery extends ViewableData {


	/**
	 *
	 * @var string - select, delete, update, insert, show
	 */
	public $type = null;

	/**
	 * @var int
	 */
	protected $duplicates = 0;

	/**
	 *
	 * @var DBStacktrace
	 */
	protected $stacktrace = null;

	/**
	 * @return bool
	 */
	public function canView() {
		return true;
	}

	/**
	 * @return string
	 */
	public function getTime() {
		return sprintf("%0.1f", $this->time);
	}

	/**
	 * @return string
	 */
	public function getBackgroundColor() {
		return substr($this->hash,0,6);
	}

	/**
	 *
	 * @param \DBStacktrace $trace
	 */
	public function setStacktrace(DBStacktrace $trace) {
		$this->stacktrace = $trace;
	}

	/**
	 *
	 * @return array
	 */
	public function getStacktrace() {
		return $this->stacktrace;
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

	/**
	 * @return mixed
	 */
	public function getSha1() {
		return $this->hash;
	}

	/**
	 * @return string
	 */
	public function getQuerySummary() {
		if(strlen($this->query)<80) {
			return false;
		}
		return substr($this->query,0,80) . '...';
	}

	/**
	 * @return mixed
	 */
	public function getQuery() {
		return $this->query;
	}

	/**
	 * @return string - select, delete, update, insert, show
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @return int
	 */
	public function getDuplicates() {
		return $this->duplicates;
	}
}