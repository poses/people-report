<?php /*
	echo $pages->display_pages();
	echo "Page $pages->current_page of $pages->num_pages";
?>
<span>
	<?php echo $pages->display_jump_menu(); ?> /
	<?php echo $pages->display_items_per_page(); ?>
</span>
<?php */?>
<div class="team-view">

	<h2 class="left">รายงานสรุปการมาทำงาน</h2>

	<form action="?action=index" method="GET" class="team-select right">
		<label for="start-team-date">ช่วงเวลา </label>
		<input type="date" name="start_date" id="start_date" value="<?php echo $startTime; ?>">

		<label for="end_date" class="date-stop">ถึงวันที่ </label>
		<input type="date" name="end_date" id="end_date" class="date-stop" value="<?php echo $endTime; ?>">

		<div class="clearfix"></div>
		<label for="employee-type">ประเภทพนักงาน</label>
		<input type="text" name="employee-type" id="employee-type" disabled>

		<div class="clearfix"></div>
		<label for="employee-type">แผนก</label>
		<select name="employee-cat" id="employee-cat">
			<option value="1">Organization Improvement</option>
		</select>

		<div class="clearfix"></div>
		<label for="employee-type">สถานะ</label>
		<input type="text" name="employee-cat" id="employee-cat" disabled>

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
				<th>ขาด</th>
				<th>ลากิจ</th>
				<th>ลาป่วย</th>
				<th>พักร้อน</th>
				<th>ลาคลอด</th>
				<th>พักร้อน</th>
				<th>ลาบวช</th>
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
			<?php foreach ( $allData as $value ) :?>
				<tr>
					<td><?php echo $value['officer_id']; ?></td>
					<td>
						<a href="?action=viewDetail&id=<?php echo $value['officer_id']; ?>">
							<?php echo $value['prename_th'] . $value['firstname'] . ' ' . $value['surname']; ?>
						</a>
					</td>
					<td><?php echo $value['site_name']; ?></td>
					<td>2</td>
					<td><?php echo date('h', 0); ?></td>
					<td>30</td>
					<td>2</td>
					<td>2</td>
					<td><?php echo $accessTypeLimit[0]['type_limit']; ?></td>
					<td>2</td>
					<td>2</td>
					<td><?php echo $accessTypeLimit[1]['type_limit']; ?></td>
					<td>2</td>
					<td>2</td>
					<td><?php echo $accessTypeLimit[2]['type_limit']; ?></td>
					<td>2</td>
					<td>2</td>
					<td><?php echo $accessTypeLimit[3]['type_limit']; ?></td>
					<td>2</td>
					<td>2</td>
					<td><?php echo $accessTypeLimit[4]['type_limit']; ?></td>
					<td>2</td>
					<td>2</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<?php echo $pages->display_pages();   ?>
</div>