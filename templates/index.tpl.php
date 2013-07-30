<?php /*
	================= Pagination Option ================
	echo $pages->display_pages();
	echo "Page $pages->current_page of $pages->num_pages";
	echo $pages->display_jump_menu();
	echo $pages->display_items_per_page();
	=====================================================
*/?>
<div class="team-view">
	<h2 class="left">รายงานสรุปการมาทำงาน</h2>
	<form action="?action=index" method="GET" class="team-select right">
		<label for="start-team-date">ช่วงเวลา </label>
		<input type="text" name="start_date" id="start_date" class="theDatepicker" value="<?php echo date('d F Y', strtotime($startTime)); ?>">

		<label for="end_date" class="date-stop">ถึงวันที่ </label>
		<input type="text" name="end_date" id="end_date" class="date-stop theDatepicker" value="<?php echo date('d F Y', strtotime($endTime)); ?>">

		<div class="clearfix"></div>
		<label for="employee-type">ตำแหน่ง</label>
		<select name="employee-cat" id="employee-cat">
			<?php foreach ($allPosition as $vPosition) : ?>
				<option value="<?php echo $vPosition['position_id']?>" <?php echo ($employeeCat == $vPosition['position_id']) ? 'selected' : '';?>><?php echo $vPosition['position_name']?></option>
			<?php endforeach; ?>
			<option value="1">Organization Improvement</option>
		</select>

		<div class="clearfix"></div>
		<label for="employeeStatus">สถานะพนักงาน</label>
		<select name="employee-status" id="employeeStatus">
			<option value="1" <?php echo ($employeeStatus == '1') ? 'selected' : '';?>>ปกติ</option>
			<option value="2" <?php echo ($employeeStatus == '2') ? 'selected' : '';?>>พ้นสภาพพนักงาน</option>
		</select>

		<div class="clearfix"></div>
		<label for="employeeType">ประเภทพนักงาน</label>
		<input type="text" name="employee-type" id="employeeType" value="พนักงานประจำ" disabled>

		<input type="submit" name="submit" value="ค้นหา">
	</form>
	<div class="clearfix"></div>
	<hr>
	<table class="summary-table">
		<thead>
			<tr>
				<th>ลำดับ</th>
				<th>ชื่อ-สกุล</th>
				<th>ตำแหน่ง</th>
				<th>สาย</th>
				<th>สาย</th>
				<th colspan="3">ขาด</th>
				<th colspan="3">ลากิจ</th>
				<th colspan="3">ลาป่วย</th>
				<th colspan="3">พักร้อน</th>
				<th colspan="3">ลาคลอด</th>
				<th colspan="3">ลาบวช</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td>ครั้ง</td>
				<td>นาที</td>
				<td class="allowed">สิทธิ</td>
				<td class="use">ใช้</td>
				<td class="remain">เหลือ</td>
				<td class="allowed">สิทธิ</td>
				<td class="use">ใช้</td>
				<td class="remain">เหลือ</td>
				<td class="allowed">สิทธิ</td>
				<td class="use">ใช้</td>
				<td class="remain">เหลือ</td>
				<td class="allowed">สิทธิ</td>
				<td class="use">ใช้</td>
				<td class="remain">เหลือ</td>
				<td class="allowed">สิทธิ</td>
				<td class="use">ใช้</td>
				<td class="remain">เหลือ</td>
				<td class="allowed">สิทธิ</td>
				<td class="use">ใช้</td>
				<td class="remain">เหลือ</td>
			</tr>
			<?php foreach ( $people as $value ) :?>
				<tr>
					<td><?php echo $value['officer_id']; ?></td>
					<td>
						<a href="?action=viewDetail&id=<?php echo $value['officer_id']; ?>" title="<?php echo $value['prename_th'] . $value['firstname'] . ' ' . $value['surname']; ?>">
							<?php echo $value['prename_th'] . $value['firstname'] . ' ' . $value['surname']; ?>
						</a>
					</td>
					<td><?php echo $allPosition[$value['office']]['position_name']; ?></td>
					<td><?php echo $value['late']; ?></td>
					<td><?php echo gmdate("H.i", $value['late_minute']); ?></td>

					<td><?php echo ($value['limit_1']['all_limit_1']) ? $value['limit_1']['all_limit_1'] : 0; ?></td>
					<td><?php echo ($value['late_with_type']['off-' . $accessTypeLimit[1]['access_type_id']]) ? $value['late_with_type']['off-' . $accessTypeLimit[1]['access_type_id']] : 0; ?></td>
					<td><?php echo $value['limit_1']['all_limit_1'] - $value['late_with_type']['off-' . $accessTypeLimit[1]['access_type_id']]; ?></td>

					<td><?php echo $value['limit_2']['all_limit_2']; ?></td>
					<td><?php echo ($value['late_with_type']['off-' . $accessTypeLimit[2]['access_type_id']]) ? $value['late_with_type']['off-' . $accessTypeLimit[2]['access_type_id']] : 0; ?></td>
					<td><?php echo $value['limit_2']['all_limit_2'] - $value['late_with_type']['off-' . $accessTypeLimit[2]['access_type_id']]; ?></td>

					<td><?php echo $value['limit_4']['all_limit_4']; ?></td>
					<td><?php echo ($value['late_with_type']['off-' . $accessTypeLimit[4]['access_type_id']]) ? $value['late_with_type']['off-' . $accessTypeLimit[4]['access_type_id']] : 0; ?></td>
					<td><?php echo $value['limit_4']['all_limit_4'] - $value['late_with_type']['off-' . $accessTypeLimit[4]['access_type_id']]; ?></td>

					<td><?php echo $value['limit_6']['all_limit_6']; ?></td>
					<td><?php echo ($value['late_with_type']['off-' . $accessTypeLimit[6]['access_type_id']]) ? $value['late_with_type']['off-' . $accessTypeLimit[6]['access_type_id']] : 0; ?></td>
					<td><?php echo $value['limit_6']['all_limit_6'] -  $value['late_with_type']['off-' . $accessTypeLimit[6]['access_type_id']]; ?></td>

					<td><?php echo $value['limit_7']['all_limit_7']; ?></td>
					<td><?php echo ($value['late_with_type']['off-' . $accessTypeLimit[7]['access_type_id']]) ? $value['late_with_type']['off-' . $accessTypeLimit[7]['access_type_id']] : 0; ?></td>
					<td><?php echo $value['limit_7']['all_limit_7'] -  $value['late_with_type']['off-' . $accessTypeLimit[7]['access_type_id']]; ?></td>

					<td><?php echo $value['limit_8']['all_limit_8']; ?></td>
					<td><?php echo ($value['late_with_type']['off-' . $accessTypeLimit[8]['access_type_id']]) ? $value['late_with_type']['off-' . $accessTypeLimit[8]['access_type_id']] : 0; ?></td>
					<td><?php echo $value['limit_8']['all_limit_8'] -  $value['late_with_type']['off-' . $accessTypeLimit[8]['access_type_id']]; ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<?php echo $pages->display_pages();   ?>
</div>
<script>
	$(function() {
		$('#start_date').Zebra_DatePicker({
			format: 'd F Y',
			pair: $('#end_date')
		});

		$('#end_date').Zebra_DatePicker({
			format: 'd F Y',
			direction: 1
		});
	});
</script>