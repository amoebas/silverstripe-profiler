<?php

class DBStacktrace extends ViewableData {

	/**
	 *
	 * @var array
	 */
	protected $stacktrace = null;

	/**
	 *
	 * @param array $stacktrace
	 */
	public function __construct($stacktrace) {
		$this->stacktrace = $stacktrace;
	}

	public function getTrace() {
		$calls = array();
		foreach($this->stacktrace as $call) {
			$string=(isset($call['class']))?$call['class']:'';
			$string.=(isset($call['class'])&&isset($call['class']))?'::':'';
			$string.=(isset($call['function']))?$call['function']:'';
			if(isset($call['include_filename'])) {
				$string.=str_replace(TEMP_FOLDER,'',$call['include_filename']);
			}
			$calls[] = $string;
		}
		return implode('<br />', $calls);
	}
}