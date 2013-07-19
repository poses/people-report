<?php
	/**
	 * Controller for process this project.
	 *
	 * @author Ting <ichaiwut.s@gmail.com>
	 */
	class Controller {
	    private $model;

	    public function __construct($model) {
	        $this->model = $model;
	    }

	    /**
	     * Index page for project
	     * @author Ting <ichaiwut.s@gmail.com>
	     */
	    public function index() {
	    	//Set default start and end date.
	    	$startTime = date('Y-m-d', strtotime('-1 day'));
	    	$endTime = date('Y-m-d', time());
	    	//If user select date.
	    	if ( $_SERVER['REQUEST_METHOD'] === 'GET' ) {
	    		//assign value from `POST`
	    		$startTime = $_GET['start_date'];
	    		$endTime = $_GET['end_date'];
	    	}

	    	//Count data for `$pages->limit`
	    	$countAll = $this->model->countAll('faceacc_officer');
	    	//Create paginate object.
	    	require_once('paginate.php');
            $pages = new Paginator;
			$pages->mid_range = 9;
			$pages->items_total = $countAll->fetchColumn();
			$pages->paginate();

	    	//Find data width between date.
	    	$allData = $this->model->findWithDate(
	    			'faceacc_log_sumperday',
	    			'faceacc_officer',
	    			'logDate',
	    			$startTime,
	    			$endTime,
	    			$pages->limit
	    		);

	        require_once('templates/index.tpl.php');
	    }

	    /**
	     * Show user detail on one person.
	     * @param  integer $id user's id.
	     * @author Ting <ichaiwut.s@gmail.com>
	     */
	    public function viewDetail($id) {
	    	$user = $this->model->findById('faceacc_officer', $id);
	    	require_once('templates/show-detail.tpl.php');
	    }


	    /**
	     * Throw all of error page to this function
	     *
	     * @author Ting <ichaiwut.s@gmail.com>
	     * @since 8 July 2013
	     */
	    public function errorPage() {
	    	require_once('templates/404.tpl.php');
	    }
	}
?>