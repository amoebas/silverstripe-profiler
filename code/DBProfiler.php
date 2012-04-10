<?php

class DBProfiler {

	protected $startedAt = null;

	protected $lastRuntime = null;

	protected $lastQuery = 'null';

	/**
	 *
	 * @var ArrayList
	 */
	protected $list = null;

	public function __construct() {
		$this->list = new DBProfilerQueryList();
	}

	public function start($sql) {
		if(in_array(get_class(Controller::curr()), array('DBProfilerViewer','DevelopmentAdmin'))) {
			return;
		}
		
		$this->lastQuery = $sql;
		$this->startedAt = microtime(true);
	}

	public function stop() {
		if(in_array(get_class(Controller::curr()), array('DBProfilerViewer','DevelopmentAdmin'))) {
			return;
		}

		$this->lastRuntime = microtime(true) - $this->startedAt;
		$query = new DBProfilerQuery();
		$query->query = $this->lastQuery;
		$query->time =$this->getLastRuntime();
		$this->list->push($query);
		$this->list->setURL($_SERVER['REQUEST_URI']);
	}

	public function getLastRuntime() {
		return round($this->lastRuntime*1000, 2);
	}

	public function __destruct() {
		if($this->list->count()) {
			file_put_contents('/tmp/profiler-'.date('Y-m-d_H-i-s_').sha1(microtime()).'.log', serialize($this->list));
		}
	}
}