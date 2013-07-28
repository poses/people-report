<?php
	/**
	 * Controller :: for process this project.
	 *
	 * @package Maximize by 3Musketters
	 * @version 1.0
	 * @author Ting <ichaiwut.s@gmail.com>
	 */
	class Controller {
	    private $model;

	    public function Controller( $model ) {
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
	    	$employeeCat = '34';

	    	//If user select date.
	    	if ( !empty($_GET['start_date']) && !empty($_GET['end_date']) && !empty($_GET['employee-cat']) ) {
	    		$startTime = date('Y-m-d', strtotime($_GET['start_date']));
	    		$endTime = date('Y-m-d', strtotime($_GET['end_date']));
	    		$employeeCat = $_GET['employee-cat'];
	    	}
	    	//Count data for `$pages->limit`
	    	$countAll = $this->model->findOfficer(true, false, $employeeCat);

	    	//Create paginate object.
	    	require_once('paginate.php');
            $pages = new Paginator;
			$pages->mid_range = 5;
			$pages->items_total = $countAll->fetchColumn();
			$pages->paginate();

	    	//Find data width between date.
	    	$allData = $this->model->findOfficer(false, $pages->limit, $employeeCat);
	    	//Get all position name form `faceacc_log_sumperday::position_name`.
	    	$allPosition = $this->model->getAllPosition();
	    	//Find access type
    		$accessTypeLimit = $this->model->findAccessTypeLimit();
    		//This variable will keep these data:
    		//     - Late per time : see `Model::larePerTimes()`.
    		//     - Late per minute : see `Model::latePerMinute()`.
    		//     - Late with type : see `Model::lateWithType()`.
	    	$people = array();
	    	foreach ( $allData as $kData => $vData ) {
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

	    		//Get late type limit per each person in the year.
				foreach ( $accessTypeLimit as $kAccess => $vAccess ) {
					//get limit type per year and user.
			    	$people[$kData]['limit_' . $kAccess] = $this->model->getLimitOfUser( $vData['officer_id'], $vAccess['access_type_id'], date('Y', strtotime($startTime)), date('Y', strtotime($endTime)));
					//Calculate all of limit type if select multiple year.
					foreach ( $people[$kData]['limit_' . $kAccess] as $kSubAccess => $vSubValue ) {
						$people[$kData]['limit_' . $kAccess]['all_limit_' . $kAccess] += $vSubValue['access_type_limit'];
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
	    public function viewDetail( $id ) {
	    	include 'templates/header.php';
	    	//Find user data.
	    	$user = $this->model->findById($id);
	    	//Set default start and end date.
	    	$startTime = date('Y-m-d', strtotime('-1 day'));
	    	$endTime = date('Y-m-d', time());
	    	//If user select date.
	    	if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
	    		$startTime = date('Y-m-d', strtotime($_POST['startDate']));
	    		$endTime = date('Y-m-d', strtotime($_POST['endDate']));
	    	}
	    	//Find access type and calculate all of access type limit.
    		$accessTypeLimit = $this->model->findAccessTypeLimit();
    		//Check gender and remove key from array.
			if ( $user[0]['gender'] == 1 ) {
				unset($accessTypeLimit[7]);
			} else {
				unset($accessTypeLimit[8]);
			}
			//Get late type limit per each person in the year.
			foreach ( $accessTypeLimit as $kAccess => $vAccess ) {
				//get limit type per year and user.
		    	$limitInType[$kAccess] = $this->model->getLimitOfUser( $id, $vAccess['access_type_id'], date('Y', strtotime($startTime)), date('Y', strtotime($endTime)));
				//Calculate all of limit type if select multiple year.
				foreach ( $limitInType[$kAccess] as $kSubAccess => $vSubValue ) {
					$limitInType[$kAccess]['all_limit_' . $kAccess] += $vSubValue['access_type_limit'];
				}
			}
			//get late with type.
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
    		//Get position name.
    		$positionName = $this->model->getPosition($id);
    		//Get site name.
    		$siteName = $this->model->getSiteName($id);

	    	require_once('templates/show-detail.tpl.php');
			include 'templates/footer.php';
	    }

	    /**
	     * Add limit time per year per each people and all people.
	     * @author Ting <ichaiwut.s@gmail.com>
	     */
	    public function add() {
			include 'templates/header.php';
			//Get year from query string.
			$thisYear = date('Y', time());
			$employeeCat = '34';
			if ( isset($_GET['year']) && !empty($_GET['year']) && !empty($_GET['sub-position']) ) {
				$thisYear = $_GET['year'];
				$employeeCat = $_GET['sub-position'];
			}

			$allPosition = $this->model->getAllPosition();
			$accessTypeLimit = $this->model->findAccessTypeLimit();
			//Count data for `$pages->limit`
	    	$countAll = $this->model->findOfficer(true, false, $employeeCat);

	    	//Create paginate object.
	    	require_once('paginate.php');
            $pages = new Paginator;
			$pages->mid_range = 5;
			$pages->items_total = $countAll->fetchColumn();
			$pages->paginate();

			//Find data width between date.
	    	$allData = $this->model->findOfficer(false, $pages->limit, $employeeCat);
			$people = array();
	    	foreach ($allData as $kData => $vData) {
	    		$people[] = $vData;
	    		//Get position name and get access pr year.
	    		$people[$kData]['position_name'] = $this->model->getPosition($vData['officer_id']);
	    		$people[$kData]['access_per_year'] = $this->model->findLimitPerYear($vData['officer_id'], $thisYear);

	    	}
	    	// Add limit of year for all user in page.
	    	if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
	    		foreach ( $people as $kPeople => $vPeople ) {
	    			foreach ($_POST as $kPost => $vPost) {
	    				//Remove `submit` value from array.
		    			if ( $kPost == 'submit' ) {
		    				unset($_POST[$kPost]);
		    				continue;
		    			}
		    			//Check `gender` of people.
		    			if (( $vPeople['gender'] == '1' &&  $kPost == '7' ) || ( $vPeople['gender'] == '2' &&  $kPost == '8' ))  {
		    				$vPost = '0';
		    			}
		    			// See `model::addAllAccess`.
		    			$addStatus = $this->model->addAllAccess( $vPeople['officer_id'], $kPost, $vPost, $thisYear );
	    			}
	    		}
	    		//Redirect to success page for reload the page.
	    		$this->successPage();
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
	     * Update limit of day-off for each people.
	     * @return json return resutl of process.
	     * @author Ting <ichaiwut.s@gmail.com>
	     */
	    public function updateOffPeople() {
	    	header('Content-Type: application/json');
	    	//Extract data for `POST` and `GET`
	    	//Then add limit value for each type
	    	//see `model::addAllAccess()`.
			$result = array();
			foreach ( $_POST as $kAccess => $vAccess ) {
				if ( $kAccess == 'id' ) continue; //Key `id` we don't want to use.
				$result[$kAccess] = $this->model->addAllAccess( $_POST['id'], $kAccess, $vAccess, $_GET['year'] );
			}

			return json_encode($result);
	    }

	    /**
	     * Redierct page.
	     * Use this if send `post` in same page and reload page are requried.
	     * @author Ting <ichaiwut.s@gmail.com>
	     */
	    function successPage() {
		    include 'templates/success.tpl.php';
	    }
	}
?>