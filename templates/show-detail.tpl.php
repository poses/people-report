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
		<div class="user-detail">
			<div class="user-desc right">
				<!--
					- User image will read on field : `$user[0]['picture']`;
					- image dimension should be `140 x 140px`.
				-->
				<img src="images/no-photo.jpg" alt="<?php echo $user[0]['firstname'] ?>" title="<?php echo $user[0]['firstname'] ?>" class="left">
				<div class="right mini-desc">
					<p>
						<strong>ชื่อ-สกุล</strong>
						<span>
							<?php echo $user[0]['prename_th']; ?>
							<?php echo $user[0]['firstname'] . ' '; ?>
							<?php echo $user[0]['surname']; ?>
						</span>
					</p>
					<p>
						<strong>ตำแหน่ง</strong>
						<span><?php echo $positionName; ?></span>
					</p>
					<p>
						<strong>แผนก</strong>
						<span><?php echo $siteName[$user[0]['site_id']]['site_name']; ?></span>
					</p>
					<p>
						<strong>เร่ิมทำงาน</strong>
						<span><?php echo date('d F Y', strtotime($user[0]['start_work'])); ?></span>
					</p>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
			<hr>
			<form action="?action=viewDetail&id=<?php echo $user[0]['officer_id']; ?>" method="POST" class="user-detail-date">
				<div class="form-label">ข้อมูลช่วงเวลา</div>

				<label for="userDetailDateFrom">วันที่ </label>
				<input type="text" id="userDetailDateFrom" class="theDatepicker" name="startDate" value="<?php echo date('d F Y', strtotime($startTime)); ?>">

				<label for="userDetailDateTo">ถึงวันที่ </label>
				<input type="text" id="userDetailDateTo" name="endDate" class="theDatepicker" value="<?php echo date('d F Y', strtotime($endTime)); ?>">

				<input type="hidden" name="id" value="<?php echo $user[0]['officer_id']; ?>">
				<input type="submit" name="Submit" value="Go">
			</form>

			<table class="detail-table">
				<thead>
					<tr>
						<th class="alignleft">ประเภทการลา</th>
						<th>ขาด</th>
						<th>ลากิจ</th>
						<th>ลาป่วย</th>
						<th>ลาพักร้อน</th>
						<th>ลาคลอด </th>
						<th>ลาบวช</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>สิทธิ์การลา</td>
						<td><?php echo ($accessTypeLimit[1]['type_limit']) ? $accessTypeLimit[1]['type_limit'] : '0'; ?></td>
						<td><?php echo $limitInType[2]['all_limit_2']; ?></td>
						<td><?php echo $limitInType[4]['all_limit_4']; ?></td>
						<td><?php echo $limitInType[6]['all_limit_6']; ?></td>
						<td><?php echo ($limitInType[7]['all_limit_7']) ? $limitInType[7]['all_limit_7']: '0'; ?></td>
						<td><?php echo ($limitInType[8]['all_limit_8']) ? $limitInType[8]['all_limit_8']: '0'; ?></td>
					</tr>
					<tr>
						<td>ลาไปแล้ว</td>
						<td data-access-id="<?php echo $accessTypeLimit[1]['access_type_id']; ?>"><?php echo ($lateWithType['off-' . $accessTypeLimit[1]['access_type_id']]) ? $lateWithType['off-' . $accessTypeLimit[1]['access_type_id']] : 0; ?></td>
						<td data-access-id="<?php echo $accessTypeLimit[2]['access_type_id']; ?>"><?php echo ($lateWithType['off-' . $accessTypeLimit[2]['access_type_id']]) ? $lateWithType['off-' . $accessTypeLimit[2]['access_type_id']] : 0; ?></td>
						<td data-access-id="<?php echo $accessTypeLimit[4]['access_type_id']; ?>"><?php echo ($lateWithType['off-' . $accessTypeLimit[4]['access_type_id']]) ? $lateWithType['off-' . $accessTypeLimit[4]['access_type_id']] : 0; ?></td>
						<td data-access-id="<?php echo $accessTypeLimit[6]['access_type_id']; ?>"><?php echo ($lateWithType['off-' . $accessTypeLimit[6]['access_type_id']]) ? $lateWithType['off-' . $accessTypeLimit[6]['access_type_id']] : 0; ?></td>
						<td data-access-id="<?php echo $accessTypeLimit[7]['access_type_id']; ?>"><?php echo ($lateWithType['off-' . $accessTypeLimit[7]['access_type_id']]) ? $lateWithType['off-' . $accessTypeLimit[7]['access_type_id']] : 0; ?></td>
						<td data-access-id="<?php echo $accessTypeLimit[8]['access_type_id']; ?>"><?php echo ($lateWithType['off-' . $accessTypeLimit[8]['access_type_id']]) ? $lateWithType['off-' . $accessTypeLimit[8]['access_type_id']] : 0; ?></td>
					</tr>
					<tr class="remain-date">
						<td>วันลาคงเหลือ</td>
						<td><?php echo $limitInType[1]['all_limit_1'] - $lateWithType['off-' . $accessTypeLimit[1]['access_type_id']]; ?></td>
						<td><?php echo $limitInType[2]['all_limit_2'] - $lateWithType['off-' . $accessTypeLimit[2]['access_type_id']]; ?></td>
						<td><?php echo $limitInType[4]['all_limit_4'] - $lateWithType['off-' . $accessTypeLimit[4]['access_type_id']]; ?></td>
						<td><?php echo $limitInType[6]['all_limit_6'] - $lateWithType['off-' . $accessTypeLimit[6]['access_type_id']]; ?></td>
						<td><?php echo $limitInType[7]['all_limit_7'] - $lateWithType['off-' . $accessTypeLimit[7]['access_type_id']]; ?></td>
						<td><?php echo $limitInType[8]['all_limit_8'] - $lateWithType['off-' . $accessTypeLimit[8]['access_type_id']]; ?></td>
					</tr>
				</tbody>
			</table>
			<table class="detail-note" id="list-dayoff">
				<!-- Render underscore template here -->
			</table>
		</div>
	</div>

	<!--
		============== UDERSCORE TEMPLATE ===================
		Create underscore template for render day off detail.
	-->
	<script type="text/html" id="js-list-dayoff">
		<thead>
			<tr>
				<th>ประเภท</th>
				<th>วัน และวันที่หมายเหตุการลา</th>
			</tr>
		</thead>
		<tbody >
			//Loop the data.
		    <%  _.each(response, function(values) { %>
		    	<tr>
		    		<td><%= values.access_type_name %></td>
		    		<td>
		    			วันที่ลา : <%= values.logDate %>, หมายเหตุ : <%= values.approve_detail%>
		            </td>
		        </tr>
		    <% });%>
		</tbody>
	</script>

	<script>
		$(function() {
			$('#userDetailDateFrom').Zebra_DatePicker({
				format: 'd F Y',
				pair: $('#userDetailDateTo')
			});

			$('#userDetailDateTo').Zebra_DatePicker({
				format: 'd F Y',
				direction: 1
			});

			$('table.detail-table tr:nth-child(2) td').on('click', function() {
				//User `underscore` to create template for day off detail.
				$.getJSON('?action=getDayOff&userId=<?php echo $id;?>&startDate=<?php echo $startTime?>&endDate=<?php echo $endTime?>',
					$(this).data(), //Second params is `data`
					function(data) {
						//If not found any data just don't show any thing.
						if ( data.length === 0 ) {
	                        $("#list-dayoff").html('');
	                    } else {
	                    	//crete `undersocer` template.
	                        var template = $("#js-list-dayoff").html();
	                        $("#list-dayoff").html( _.template(template, {response : data}) );
	                    }
				});
			});
		});
	</script>

	</body>