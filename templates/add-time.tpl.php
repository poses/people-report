<div class="add-dayoff">
	<h2>แบบฟรอ์มจำนวนวันลางาน</h2>

	<form action="?action=add" method="GET" class="filter left">
		<label for="subPosition">ฝ่าย</label>
		<select name="sub-position" id="subPosition">
			<?php foreach ( $allPosition as $vPosition )  :?>
				<option value="<?php echo $vPosition['position_name']; ?>"><?php echo $vPosition['position_name']; ?></option>
			<?php endforeach ?>
		</select>

		<div class="clearfix"></div>
		<label for="subPosition">สถานะ</label>
		<select name="sub-position" id="subPosition">
			<option value="">ยังไม่มีสถานะ้</option>
		</select>

		<div class="clearfix"></div>
		<label for="subPosition">ประจำปี</label>
		<input type="text" class="datepicker" value="<? echo $thisYear;?>">

		<div class="clearfix"></div>
		<input type="submit" value="submit" name="submit">
	</form>

	<form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="POST" class="add-dayoff right">
		<div class="form-label">ระเบียบบริษัท</div>

		<label for="businessOff">ลากิจ</label>
		<input type="text" name="2" id="business-off" value="<?php echo $accessTypeLimit[2]['type_limit'];?>">

		<div class="clearfix"></div>
		<label for="sickOff">ลาป่วย</label>
		<input type="text" name="4" id="sickOff" value="<?php echo $accessTypeLimit[4]['type_limit'];?>">

		<div class="clearfix"></div>
		<label for="summerOff">ลาพักร้อน</label>
		<input type="text" name="6" id="summerOff" value="<?php echo $accessTypeLimit[6]['type_limit'];?>">

		<div class="clearfix"></div>
		<label for="pregnantOff">ลาคลอด</label>
		<input type="text" name="7" id="pregnantOff" value="<?php echo $accessTypeLimit[7]['type_limit'];?>">

		<div class="clearfix"></div>
		<label for="ordinateOff">ลาบวช</label>
		<input type="text" name="8" id="ordinateOff" value="<?php echo $accessTypeLimit[8]['type_limit'];?>">

		<div class="clearfix"></div>
		<input type="submit" value="แก้ไข" name="submit">
	</form>
	<div class="clearfix"></div>

	<hr>

	<form action="" class="add-time">
		<table class="list-to-add">
			<thead>
				<tr>
					<th class="aligncenter">ลำดับ</th>
					<th>ชื่อ-สกุล</th>
					<th>ตำแหน่ง</th>
					<th>แผนก</th>
					<th>ลากิจ</th>
					<th>ลาป่วย</th>
					<th>ลาพักร้อน</th>
					<th>ลาบวช</th>
					<th>ลาคลอด</th>
					<th>หมายเหตุ</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $people as $value ) : ?>
					<tr>
						<td class="aligncenter"><?php echo $value['officer_id'] ?></td>
						<td><?php echo $value['firstname'] . ' ' . $value['surname'] ?></td>
						<td><?php echo $value['position_name']; ?></td>
						<td>nothing</td>
						<!-- <td><input type="text" name="addBusiness"></td>
						<td><input type="text" name="addBusiness"></td>
						<td><input type="text" name="addBusiness"></td>
						<td><input type="text" name="addBusiness"></td>
						<td><input type="text" name="addBusiness"></td>
						<td><input type="submit" name="addBusiness"></td> -->
						<td><?php echo $value['access_per_year']['type-2']['access_type_limit']; ?></td>
						<td><?php echo $value['access_per_year']['type-4']['access_type_limit']; ?></td>
						<td><?php echo $value['access_per_year']['type-6']['access_type_limit']; ?></td>
						<td><?php echo $value['access_per_year']['type-7']['access_type_limit']; ?></td>
						<td><?php echo $value['access_per_year']['type-8']['access_type_limit']; ?></td>
						<td>ตกลง</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</form>
	<?php echo $pages->display_pages();   ?>
</div>
<script>
	$(function() {
		$('.datepicker').Zebra_DatePicker({
			view: 'years',
			format: 'Y'
		});
	});
</script>