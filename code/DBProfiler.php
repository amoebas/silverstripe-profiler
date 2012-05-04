<?php

class DBProfiler {

	/**
	 *
	 * @var string
	 */
	protected static $log_dir = null;

	/**
	 *
	 * @var float
	 */
	protected $startedAt = null;

	/**
	 *
	 * @var int
	 */
	protected $lastRuntime = null;

	/**
	 *
	 * @var string
	 */
	protected $lastQuery = '';

	/**
	 *
	 * @var DBStacktrace
	 */
	protected $lastStacktrace = null;

	/**
	 *
	 * @var ArrayList
	 */
	protected $list = null;

	/**
	 *
	 * @return string
	 */
	public static function get_log_dir() {
		if(self::$log_dir) {
			$dir = self::$log_dir;
		} else {
			$dir = TEMP_FOLDER.DIRECTORY_SEPARATOR.'profiler'.DIRECTORY_SEPARATOR;
		}
		self::check_dir($dir);
		return $dir;
	}

	/**
	 *
	 * @staticvar null $dir_exists
	 * @param type $dir
	 * @return boolean
	 */
	protected static function check_dir($dir) {
		static $dir_exists = null;
		if($dir_exists) { return true; }
		if(!is_dir($dir)) {  $dir_exists = mkdir($dir, 0777, true); }
		else { $dir_exists = true; }
	}

	/**
	 *
	 */
	public function __construct() {
		$this->list = new DBProfilerQueryList();
	}

	/**
	 *
	 */
	public function __destruct() {
		if($this->list->count()) {
			$this->saveReport($this->list);
		}
	}

	/**
	 *
	 * @param strings $sql
	 * @return void
	 */
	public function start($sql) {
		if(in_array(get_class(Controller::curr()), array('DBProfilerViewer','DevelopmentAdmin'))) {
			return;
		}
		if(function_exists('xdebug_get_function_stack')) {
			$stack = xdebug_get_function_stack();
			
			$this->lastStacktrace = new DBStacktrace(array_slice($stack,0,-2));
		}
		$this->lastQuery = $sql;
		$this->startedAt = microtime(true);
	}

	/**
	 *
	 * @return type
	 */
	public function stop() {
		// Some URLs should be ignored
		if(in_array(get_class(Controller::curr()), array('DBProfilerViewer','DevelopmentAdmin'))) {
			return;
		}
		$this->setLastRuntime(microtime(true));
		
		$query = new DBProfilerQuery();
		$query->query = $this->lastQuery;
		$query->time =$this->getLastRuntime();
		if($this->lastStacktrace) {
			$query->setStacktrace($this->lastStacktrace);
		}
		
		$this->list->push($query);
		$this->list->setURL(Controller::curr()->getRequest()->getUrl());
	}

	/**
	 *
	 * @param float $time
	 */
	protected function setLastRuntime($time){
		$this->lastRuntime = $time- $this->startedAt;
	}

	/**
	 *
	 * @return float
	 */
	protected function getLastRuntime() {
		return round($this->lastRuntime*1000, 2);
	}

	/**
	 *
	 * @param ArrayList $list
	 */
	protected function saveReport($list) {
		$serializedList = serialize($list);
		$filepath = self::get_log_dir().'profiler-'.date('Y-m-d_H-i-s_');
		$filepath.= sha1($serializedList).'.log';
        $fp = fopen($filepath, 'w');
        if(flock($fp, LOCK_EX)){
			fwrite($fp, $serializedList);
			fflush($fp);
			flock($fp, LOCK_UN);
        }
        fclose($fp);
	}
}