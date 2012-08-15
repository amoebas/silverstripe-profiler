<?php
if(method_exists('DB', 'set_profiler')) {
	DB::set_profiler(new DBProfiler());
}

#Director::addRules(11, array('dev/profiler' => 'DBProfilerViewer'));
