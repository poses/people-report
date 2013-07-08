<?php
	/**
	 * Main page and landing of project.
	 *
	 * @copyright 2013 use for personal only.
	 * @author Ting <ichaiwut.s@gmail.com>
	 * @since 8 July 2013
	 */

	require('boostraps.php');
	require('model.php');
	require('controller.php');

	//Create `controller` object.
	$model = new Model();
	$controller = new Controller($model);
	$action = $_GET['action'];

	include 'templates/header.php';
	//If user not type any action redirect to _not found page_.
	if ( empty($action) ) {
		//Redirect to `404` page.
		$controller->errorPage();
	} else {
		//and use `$action` for function name.
		$controller->$action();
	}

	include 'templates/footer.php';

?>