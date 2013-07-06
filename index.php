<?php
	/**
	 * Main index file of project
	 *
	 * @copyright Licenced for Shapphire Company Limited.
	 * @author Ting <ichaiwut.s@gmail.com>
	 * @since 6 July 2013
	 */

	//Include **important** files.
	require 'include/function.php'; //Function will store every process.
	//Render template
	include 'layout/header.php';
	include $mainContent;
	include 'layout/footer.php';

?>