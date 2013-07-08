<?php
	/**
	 * Main page and landing of project.
	 *
	 * @copyright 2013 use for personal only.
	 * @author Ting <ichaiwut.s@gmail.com>
	 * @since 8 July 2013
	 */

	require('controller.php');
	$action = $_GET['action'];

	//If user not type any action redirect to _not found page_.
	if ( empty($action) ) {
		//@TODO : Redirect to not found page.
		echo "Not Found.";
		exit();
	}

	include 'header.php';
	//Create `controller` object.
	//and use `$action` for function name.
	$controller = new Controller();
	$controller->$action();

	include 'footer.php';
?>