<?php
	/**
	 * Header page : the header template.
	 * @author Ting <ichaiwut.@gmail.com>
	 */
	header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="en-us">
	<head>
		<meta charset="utf-8">
		<title>รายงานเวลาการทำงานของพนักงาน</title>
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/default.css">
		<script src="js/jquery-1.9.1.min.js"></script>
		<script src="js/modernizr.js"></script>
		<script src="js/underscore-min.js"></script>
		<script src="js/zebra_datepicker.js"></script>
	</head>
	<body>
		<div class="container">
			<header class="header">
				<!-- @TODO : Add logo file here? -->
			</header>
			<nav class="top-nav">
				<ul class="alignright">
					<li>
						<a href="?action=index">
							Home <br>
							<small>หน้าแรก</small>
						</a>
					</li>
					<li>
						<a href="?action=add">
							Add Data <br>
							<small>บันทึกการมาทำงาน</small>
						</a>
					</li>
					<li>
						<a href="#">
							Knowladge sharing<br>
							<small>ความรู้แต่ละฝ่ายงาน</small>
						</a>
					</li>
					<li>
						<a href="#">
							Application<br>
							<small>บริหารจัดการภายใน</small>
						</a>
					</li>
					<li>
						<a href="#">
							Morning monday<br>
							<small>กวีสั้นเช้าวันจันทร์</small>
						</a>
					</li>
					<li>
						<a href="#">
							Hr news<br>
							<small>ข่าวจากฝ่ายบุคคล</small>
						</a>
					</li>
				</ul>
			</nav>
			<section class="main-container">