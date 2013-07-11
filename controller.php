<?php
	/**
	 * Controller for process this project.
	 *
	 * @author Ting <ichaiwut.s@gmail.com>
	 * @since 8 July 2013
	 */
	class Controller {
	    private $model;

	    public function __construct($model) {
	        $this->model = $model;
	    }

	    /**
	     * Index page for project
	     *
	     * @author Ting <ichaiwut.s@gmail.com>
	     * @since 8 July 2013
	     * @modify 9 July 2013 Find data with `start` and `end` date
	     */
	    public function index() {
	    	//Set default start and end date.
	    	$startTime = date('Y-m-d', strtotime('-1 day'));
	    	$endTime = date('Y-m-d', time());
	    	//If user select date.
	    	if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
	    		//assign value from `POST`
	    		$startTime = $_POST['start_date'];
	    		$endTime = $_POST['end_date'];
	    	}

	    	//Find data width between date.
	    	$allData = $this->model->findWithDate(
	    			'faceacc_log_sumperday',
	    			'logDate',
	    			$startTime,
	    			$endTime
	    		);

	    	//find employee type
	    	// $type = $this->model->findAll();
	        require_once('templates/index.tpl.php');
	    }

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