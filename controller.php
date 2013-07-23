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

	    	//Find access type
    		$accessTypeLimit = $this->model->findAccessTypeLimit();

    		//This variable will keep these data:
    		//     - Late per time : see `Model::larePerTimes()`.
    		//     - Late per minute : see `Model::latePerMinute()`.
    		//     - Late with type : see `Model::lateWithType()`.
	    	$people = array();
	    	foreach ($allData as $kData => $vData) {
	    		$people[] = $vData;
 	    		$people[$kData]['late'] = $this->model->latePerTimes($vData['officer_id'], $startTime, $endTime);
	    		$people[$kData]['late_minute'] = $this->model->latePerMinute($vData['officer_id'], $startTime, $endTime);
	    		$people[$kData]['late_with_type'] = $this->model->lateWithType($vData['officer_id'], $startTime, $endTime);
	    		//Find data and count put to the same `access type`.
	    		foreach ( $people[$kData]['late_with_type'] as $kType => $vType ) {
	    			foreach ( $accessTypeLimit as $kAccess => $vAccess) {
						if ( $vAccess['access_type_id'] == $vType ) {
							$countOff[$vAccess['access_type_id']] = ( $countOff[$vAccess['access_type_id']] < 1 ) ? 1 : $countOff[$vAccess['access_type_id']] += 1;
							$people[$kData]['late_with_type']['off-' . $vAccess['access_type_id']] = $countOff[$vAccess['access_type_id']];
						}
	    			}
	    		}
	    	}

	        require_once('templates/index.tpl.php');
	    }

	    /**
	     * Show user detail on one person.
	     * @param  integer $id user's id.
	     * @author Ting <ichaiwut.s@gmail.com>
	     */
	    public function viewDetail($id) {
	    	$user = $this->model->findById($id);

	    	//Set default start and end date.
	    	$startTime = date('Y-m-d', strtotime('-1 day'));
	    	$endTime = date('Y-m-d', time());

	    	//If user select date.
	    	if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
	    		$startTime = $_POST['startDate'];
	    		$endTime = $_POST['endDate'];
	    	}

	    	//Find access type and calculate all of access type limit.
    		$accessTypeLimit = $this->model->findAccessTypeLimit();
    		$accessTypeLimit['All'] = 1;
    		foreach ($accessTypeLimit as $kAll => $vAll) {
    			$accessTypeLimit['All'] += $vAll['type_limit'];
    		}

    		$lateWithType = $this->model->lateWithType( $id, $startTime, $endTime);
    		foreach ( $lateWithType as $kType => $vType ) {


    			foreach ( $accessTypeLimit as $kAccess => $vAccess) {
					if ( $vAccess['access_type_id'] == $vType ) {
						$countOff[$vAccess['access_type_id']] = ( $countOff[$vAccess['access_type_id']] < 1 ) ? 1 : $countOff[$vAccess['access_type_id']] += 1;
						$lateWithType['off-' . $vAccess['access_type_id']] = $countOff[$vAccess['access_type_id']];
						unset($lateWithType[$kType]);
					}
    			}
    		}

    		$countAll = 0;
    		foreach ( $lateWithType as $kLate => $vLate) {
    			$countAll += $vLate;
    		}

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