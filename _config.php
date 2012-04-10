<?php
DB::set_profiler(new DBProfiler());
Director::addRules(11, array('dev/profiler' => 'DBProfilerViewer'));