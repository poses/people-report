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
		<input type="text" class="datepicker" value="<? echo date('Y');?>">

		<div class="clearfix"></div>
		<input type="submit" value="submit" name="submit">
	</form>

	<form action="?action=add" method="POST" class="add-dayoff right">
		<div class="form-label">ระเบียบบริษัท</div>

		<label for="businessOff">ลากิจ</label>
		<input type="text" name="businessOff" id="business-off" value="<?php echo $accessTypeLimit[2]['type_limit'];?>">

		<div class="clearfix"></div>
		<label for="sickOff">ลาป่วย</label>
		<input type="text" name="sickOff" id="sickOff" value="<?php echo $accessTypeLimit[4]['type_limit'];?>">

		<div class="clearfix"></div>
		<label for="pregnantOff">ลาคลอด</label>
		<input type="text" name="pregnantOff" id="pregnantOff" value="<?php echo $accessTypeLimit[7]['type_limit'];?>">

		<div class="clearfix"></div>
		<label for="ordinateOff">ลาบวช</label>
		<input type="text" name="ordinateOff" id="ordinateOff" value="<?php echo $accessTypeLimit[8]['type_limit'];?>">

		<div class="clearfix"></div>
		<input type="submit" value="แก้ไข" name="submit">
	</form>
	<div class="clearfix"></div>

	<hr>


</div>
<script>
	$(function() {
		$('.datepicker').Zebra_DatePicker({
			view: 'years',
			format: 'Y'
		});
	});
</script>