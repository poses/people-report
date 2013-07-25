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
	    	include 'templates/header.php';
	    	//Set default start and end date.
	    	$startTime = date('Y-m-d', strtotime('-1 day'));
	    	$endTime = date('Y-m-d', time());
	    	$employeeCat = '';

	    	//If user select date.
	    	if ( !empty($_GET['start_date']) && !empty($_GET['end_date']) && !empty($_GET['employee-cat']) ) {
	    		$startTime = $_GET['start_date'];
	    		$endTime = $_GET['end_date'];
	    		$employeeCat = $_GET['employee-cat'];
	    	}

	    	//Count data for `$pages->limit`
	    	$countAll = $this->model->findOfficer(true, $employeeCat);

	    	//Create paginate object.
	    	require_once('paginate.php');
            $pages = new Paginator;
			$pages->mid_range = 5;
			$pages->items_total = $countAll->fetchColumn();
			$pages->paginate();

	    	//Find data width between date.
	    	$allData = $this->model->findOfficer(false, $employeeCat, $pages->limit);

	    	//Get all position name form `faceacc_log_sumperday::position_name`.
	    	$allPosition = $this->model->getAllPosition();

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
	    		$people[$kData]['position_name'] = $this->model->getPosition($vData['officer_id']);
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
			include 'templates/footer.php';
	    }

	    /**
	     * Show user detail on one person.
	     * @param  integer $id user's id.
	     * @author Ting <ichaiwut.s@gmail.com>
	     */
	    public function viewDetail($id) {
	    	include 'templates/header.php';
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

			if ( $user[0]['gender'] == 1 ) {
				unset($accessTypeLimit[7]);
			} else {
				unset($accessTypeLimit[8]);
			}


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

    		$positionName = $this->model->getPosition($id);

	    	require_once('templates/show-detail.tpl.php');
			include 'templates/footer.php';
	    }

	    public function add() {
			include 'templates/header.php';

			$thisYear = date('Y', time());
			if ( isset($_GET['year']) && !empty($_GET['year']) ) {
				$thisYear = $_GET['year'];
			}

			$allPosition = $this->model->getAllPosition();
			$accessTypeLimit = $this->model->findAccessTypeLimit();

			//Count data for `$pages->limit`
	    	$countAll = $this->model->findOfficer(true, $employeeCat);

	    	//Create paginate object.
	    	require_once('paginate.php');
            $pages = new Paginator;
			$pages->mid_range = 5;
			$pages->items_total = $countAll->fetchColumn();
			$pages->paginate();

			//Find data width between date.
	    	$allData = $this->model->findOfficer(false, $employeeCat, $pages->limit);
			$people = array();
	    	foreach ($allData as $kData => $vData) {
	    		$people[] = $vData;
	    		$people[$kData]['position_name'] = $this->model->getPosition($vData['officer_id']);
	    		$people[$kData]['access_per_year'] = $this->model->findLimitPerYear($vData['officer_id'], $thisYear);

	    	}

	    	if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {

	    		foreach ( $people as $kPeople => $vPeople ) {
	    			foreach ($_POST as $kPost => $vPost) {

		    			if ( $kPost == 'submit' ) {
		    				unset($_POST[$kPost]);
		    				continue;
		    			}

		    			if (( $vPeople['gender'] == '1' &&  $kPost == '7' )
		    			      || ( $vPeople['gender'] == '2' &&  $kPost == '8' ))  {
		    				$vPost = '0';
		    			}

		    			$addStatus = $this->model->addAllAccess( $vPeople['officer_id'], $kPost, $vPost, $thisYear );
	    			}
	    		}
	    	}

			require_once('templates/add-time.tpl.php');
			include 'templates/footer.php';
	    }

	    /**
	     * Get day-off detail
	     *
	     * @return json day off data.
	     * @author Ting <ichaiwut.s@gmail.com>
	     */
	    public function getDayOff() {
	    	//Set content type for `json`
			header('Content-Type: application/json');
			//If user not sent `id` return `false`
	    	if ( empty($_GET['accessId']) || $_GET['accessId'] == 0 ) {
	    		return json_encode(false);
	    	}
	    	//Find day off detail.
	    	$dayOff = $this->model->getDayOffByUser($_GET['userId'], $_GET['accessId'], $_GET['startDate'], $_GET['endDate']);
	    	//convert date format.
	    	foreach ( $dayOff as $kOff => $vOff ) {
				$dayOff[$kOff]['logDate'] = date('d F Y', strtotime($vOff['logDate']));
	    	}

	    	echo json_encode($dayOff);
	    }

	    /**
	     * Throw all of error page to this function
	     *
	     * @author Ting <ichaiwut.s@gmail.com>
	     * @since 8 July 2013
	     */
	    public function errorPage() {
	    	include 'templates/header.php';
	    	require_once('templates/404.tpl.php');
			include 'templates/footer.php';
	    }
	}
?>