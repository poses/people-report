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
		<select name="sub-position" id="subPosition">
			<option value="1">ฝ่ายนัน้</option>
		</select>
	</form>

	<form action="?action=add" method="POST" class="add-dayoff right">
		<div class="form-label">ระเบียบบริษัท</div>

		<label for="businessOff">ลากิจ</label>
		<input type="text" name="businessOff" id="business-off">

		<div class="clearfix"></div>
		<label for="sickOff">ลาป่วย</label>
		<input type="text" name="sickOff" id="sickOff">

		<div class="clearfix"></div>
		<label for="pregnantOff">ลาคลอด</label>
		<input type="text" name="pregnantOff" id="pregnantOff">

		<div class="clearfix"></div>
		<label for="ordinateOff">ลาบวช</label>
		<input type="text" name="ordinateOff" id="ordinateOff">

		<div class="clearfix"></div>
		<input type="submit" value="submit" name="submit">
	</form>
	<div class="clearfix"></div>
</div>