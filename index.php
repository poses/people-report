<?php
	/**
	 * Main page and landing of project.
	 * @copyright 2013 use for personal only.
	 * @author Ting <ichaiwut.s@gmail.com>
	 */

	require('boostraps.php');
	require('model.php');
	require('controller.php');

	//Create `controller` object.
	$model = new Model();
	$controller = new Controller($model);
	$action = $_GET['action'];
	$params = $_GET['id'];

	//If user not type any action redirect to _not found page_.
	if ( empty($action) ) {
		//Redirect to index page.
		$controller->index();
	} else {
		//and use `$action` for function name.
		$controller->$action(($params) ? $params : '');
	}

?>