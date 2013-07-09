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
	     */
	    public function index() {
	    	//Find data width between date.
	    	$allData = $this->model->findWithDate(
	    			'faceacc_log_sumperday',
	    			'logDate',
	    			'2011-01-03',
	    			'2011-01-03'
	    		);
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