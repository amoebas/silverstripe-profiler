<?php

/**
 *
 */
class DBProfilerViewer extends Controller {

	/**
	 * @var array
	 */
	private static $allowed_actions = array(
		'show',
	);

	/**
	 * @var array
	 */
	public static $url_handlers = array(
		'' => 'index',
		'$Action' => 'show',
	);

	/**
	 * @var ArrayList
	 */
	protected $List = null;

	/**
	 *
	 */
	public function init() {
		parent::init();
		$jQuery = Controller::join_links(Director::absoluteBaseURL(), THIRDPARTY_DIR, 'jquery/jquery.js');
		Requirements::javascript($jQuery);
		Requirements::javascript('//cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js');
		Requirements::javascript('profiler/javascript/dbprofiler.js');
		Requirements::css('//cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css');
		Requirements::css('profiler/css/dbprofiler.css');
		$debugCSS = Controller::join_links(Director::absoluteBaseURL(), FRAMEWORK_DIR, 'css/debug.css');
		Requirements::css($debugCSS);
	}

	/**
	 *
	 * @param SS_HTTPRequest $request
	 * @return \HTMLText
	 */
	public function index(SS_HTTPRequest $request) {
		$list = new ArrayList();
		foreach($this->getHistory() as $data) {
			$query = unserialize(file_get_contents($data['filepath']));
			$query->DateTime = $data['date'];
			$query->Sha1 = $data['sha'];
			$list->push($query);
		}
		$this->List = $list;
		return $this->renderWith('DBProfilerViewer_index');
	}

	/**
	 * @return string
	 */
	public function Link() {
		return Director::absoluteBaseURL().'dev/profiler/';
	}

	/**
	 *
	 * @param SS_HTTPRequest $request
	 * @return \HTMLText
	 */
	public function show(SS_HTTPRequest $request) {
		$sha = $request->param('Action');
		$list = $this->getLogData($sha);
		$this->List = $list;
		return $this->renderWith('DBProfilerViewer_show');
	}

	/**
	 *
	 * @staticvar array $niceList
	 * @return array|string
	 */
	protected function getHistory() {
		static $niceList = array();

		if($niceList) {
			return $niceList;
		}

		$pattern = '|profiler-([0-9]*-[0-9]*-[0-9]*)_([0-9]*-[0-9]*-[0-9]*)_(.*)\.log|';

		$list = glob(DBProfiler::get_log_dir().'profiler-*.log');

		foreach($list as $filepath) {
			preg_match($pattern, $filepath, $matches);
			$niceList[] = array(
				'sha' => $matches[3],
				'date' => ($matches[1].' '.str_replace('-', ':', $matches[2])),
				'filepath' => $filepath
			);
		}

		usort($niceList, function($a, $b){
			if($a['date']==$b['date']) return 0;
			return $a['date'] > $b['date']?-1:1;
		});
		return $niceList;
	}

	/**
	 *
	 * @param string $sha
	 * @return DBProfilerQueryList
	 */
	protected function getLogData($sha) {
		$niceList = new DBProfilerQueryList();
		foreach($this->getHistory() as $item) {
			if($item['sha'] == $sha) {
				$queries = unserialize(file_get_contents($item['filepath']));
				break;
			}
		}
		
		$niceList->setURL($queries->getURL());
		foreach($queries as $query) {
			$niceList->push($this->getAnalyzedQueryObject($query));
		}

		$niceList= $this->markDuplicates($niceList);

		return $niceList;
	}

	/**
	 * @param $list
	 * @return DBProfilerQueryList
	 */
	protected function markDuplicates($list) {
		$counted = array_count_values($list->column('hash'));
		$result = new DBProfilerQueryList();
		foreach($list as $item) {
			if($counted[$item->hash] >= 2) {
				$item->duplicates = $counted[$item->hash];
			}
			$result->push($item);
		}
		return $result;
	}

	/**
	 * @param $query
	 * @return string
	 */
	protected function getAnalyzedQueryObject($query) {
		preg_match_all('|\"([a-z_A-Z]*)\"\."([a-z_A-Z]*)\"|', $query->query, $matches);
		$query->tables = array_unique($matches[1]);
		$query->hash = sha1($query->query);
		
		if(strpos(trim($query->query), 'SELECT') === 0) {
			$query->type  = 'select';
		} elseif(strpos(trim($query->query), 'DELETE') === 0) {
			$query->type  = 'delete';
		} elseif(strpos(trim($query->query), 'UPDATE') === 0) {
			$query->type = 'update';
		} elseif(strpos(trim($query->query), 'INSERT') === 0) {
			$query->type = 'insert';
		} elseif(strpos(trim($query->query), 'SHOW') === 0) {
			$query->type = 'show';
		} elseif(strpos(trim($query->query), 'DESCRIBE') === 0) {
			$query->type = 'show';
		}
		return $query;
	}
}