<?php
	/**
	 * Controller for process this project.
	 *
	 * @package Maximize by 3Musketters
	 * @version 1.0
	 * @author Ting <ichaiwut.s@gmail.com>
	 */
	class Controller {
	    private $model;

	    public function Controller($model) {
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
	    	if ( !empty($_GET['start_date']) && !empty($_GET['end_date']) ) {
	    		$startTime = $_GET['start_date'];
	    		$endTime = $_GET['end_date'];
	    	}

	    	//Count data for `$pages->limit`
	    	$countAll = $this->model->findOfficer(true);

	    	//Create paginate object.
	    	require_once('paginate.php');
            $pages = new Paginator;
			$pages->mid_range = 5;
			$pages->items_total = $countAll->fetchColumn();
			$pages->paginate();

	    	//Find data width between date.
	    	$allData = $this->model->findOfficer(false, $pages->limit);

	    	$people = array();
	    	foreach ($allData as $kData => $vData) {
	    		$people[] = $vData;
 	    		$people[$kData]['late'] = $this->model->latePerTimes($vData['officer_id'], $startTime, $endTime);
	    	}

	    	//Find access type
    		$accessTypeLimit = $this->model->findAccessTypeLimit();


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