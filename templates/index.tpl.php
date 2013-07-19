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
		<input type="date" name="start_date" id="start_date" value="<?php echo $_GET['start_date']?>">

		<label for="end_date" class="date-stop">ถึงวันที่ </label>
		<input type="date" name="end_date" id="end_date" class="date-stop" value="<?php echo $_GET['end_date']?>">

		<div class="clearfix"></div>
		<label for="employee-type">ประเภทพนักงาน</label>
		<input type="text" name="employee-type" id="employee-type" disabled>

		<div class="clearfix"></div>
		<label for="employee-type">ฝ่าย</label>
		<select name="employee-cat" id="employee-cat">
			<option value="1">Organization Improvement</option>
		</select>

		<div class="clearfix"></div>
		<label for="employee-type">สถานะ</label>
		<input type="text" name="employee-cat" id="employee-cat" disabled>

		<input type="submit" name="submit" value="ค้นหา">
	</form>
	<div class="clearfix"></div>

	<table class="summary-table">
		<thead>
			<tr>
				<th>ลำดับ</th>
				<th>ชื่อ-สกุล</th>
				<th>ตำแหน่ง</th>
				<th>แผนก</th>
				<th>สาย(นาทีี)</th>
				<th>สาย(ครั้ง)</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $allData as $value ) :?>
				<tr>
					<td><?php echo $value['officer_id']; ?></td>
					<td>
						<a href="?action=viewDetail&id=<?php echo $value['officer_id']; ?>">
							<?php echo $value['firstname']; ?> <?php echo $value['surname']; ?>
						</a>
					</td>
					<td><?php echo $value['position_name']; ?></td>
					<td><?php echo $value['site_name']; ?></td>
					<td><?php echo $value['time_late']; ?> นาที</td>
					<td><?php echo $value['time_late']; ?> นาที</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<?php echo $pages->display_pages();   ?>
</div>