<div class="add-dayoff">
	<h2>แบบฟรอ์มจำนวนวันลางาน</h2>

	<form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="GET" class="filter left">
		<label for="subPosition">ตำแหน่ง</label>
		<select name="sub-position" id="subPosition">
			<option value="" <?php echo empty($employeeCat) ? 'selected' : '';?>>ทั้งหมด</option>
			<?php foreach ( $allPosition as $vPosition )  :?>
				<option value="<?php echo $vPosition['position_id']; ?>" <?php echo ($employeeCat == $vPosition['position_id']) ? 'selected' : '';?>><?php echo $vPosition['position_name']; ?></option>
			<?php endforeach ?>
		</select>

		<div class="clearfix"></div>
		<label for="employeeSite">แผนก</label>
		<select name="employee-site" id="employeeSite">
			<option value="" <?php echo empty($employeeSite) ? 'selected' : '';?>>ทั้งหมด</option>
			<?php foreach ($allSites as $vSite) : ?>
				<option value="<?php echo $vSite['site_id']?>" <?php echo ($employeeSite == $vSite['site_id']) ? 'selected' : '';?>><?php echo $vSite['site_name']?></option>
			<?php endforeach; ?>
		</select>

		<div class="clearfix"></div>
		<label for="employeeStatus">สถานะ</label>
		<select name="employee-status" id="employeeStatus">
			<option value="1" <?php echo ($employeeStatus == '1') ? 'selected' : '';?>>ปกติ</option>
			<option value="2" <?php echo ($employeeStatus == '2') ? 'selected' : '';?>>พ้นสภาพพนักงาน</option>
		</select>

		<div class="clearfix"></div>
		<label for="year">ประจำปี</label>
		<input type="text" name="year" class="datepicker" value="<? echo $thisYear;?>">

		<div class="clearfix"></div>
		<input type="hidden" name="action" value="add">
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
		<input type="submit" value="แก้ไข" name="submit" id="addAllDayOff">
	</form>
	<div class="clearfix"></div>

	<hr>
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
				<th>ลาคลอด</th>
				<th>ลาบวช</th>
				<th>แก้ไข</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $people as $value ) : ?>
				<tr>
					<td class="aligncenter"><?php echo $value['officer_id'] ?></td>
					<td><?php echo $value['prename_th'] . $value['firstname'] . ' ' . $value['surname'] ?></td>
					<td><?php echo $allPosition[$value['office']]['position_name']; ?></td>
					<td><?php echo $value['site_name'][$value['site_id']]['site_name']; ?></td>
					<td>
						<input
							type="text"
							value="<?php echo $value['access_per_year']['type-2']['access_type_limit']; ?>"
							data-limit="<?php echo $value['access_per_year']['type-2']['access_type_limit']; ?>"
							data-id="<?php echo $value['officer_id']; ?>"
							data-type="2"
							name="business"
						>
					</td>
					<td>
						<input
							type="text"
							value="<?php echo $value['access_per_year']['type-4']['access_type_limit']; ?>"
							data-limit="<?php echo $value['access_per_year']['type-4']['access_type_limit']; ?>"
							data-id="<?php echo $value['officer_id']; ?>"
							data-type="4"
							name="sick"
						>
					</td>
					<td>
						<input
							type="text"
							value="<?php echo $value['access_per_year']['type-6']['access_type_limit']; ?>"
							data-limit="<?php echo $value['access_per_year']['type-6']['access_type_limit']; ?>"
							data-id="<?php echo $value['officer_id']; ?>"
							data-type="6"
							name="summer"
						>
					</td>
					<td>
						<input
							type="text"
							value="<?php echo ($value['access_per_year']['type-7']['access_type_limit'] == '0') ? '-': $value['access_per_year']['type-7']['access_type_limit']; ?>"
							data-limit="<?php echo $value['access_per_year']['type-6']['access_type_limit']; ?>"
							data-id="<?php echo $value['officer_id']; ?>"
							data-type="7"
							name="pregnant"
							<?php echo ($value['gender'] == '2') ? '' : 'disabled'; ?>
						>
					</td>
					<td>
						<input
							type="text"
							value="<?php echo ($value['access_per_year']['type-8']['access_type_limit'] == '0') ? '-': $value['access_per_year']['type-8']['access_type_limit'];?>"
							data-limit="<?php echo $value['access_per_year']['type-6']['access_type_limit']; ?>"
							data-id="<?php echo $value['officer_id']; ?>"
							data-type="8"
							name="monk"
							<?php echo ($value['gender'] == '1') ? '' : 'disabled'; ?>
						>
					</td>
					<td class="add-dayoff-ok">ตกลง</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<div class="left"> <?php echo $pages->display_pages(); ?> </div>
	<div class="right">
		<button class="addAll">บันทึกทั้งหมด</button>
	</div>
	<div class="clearfix"></div>
</div>
<script>
	$(function() {
		$('.datepicker').Zebra_DatePicker({
			view: 'years',
			format: 'Y'
		});

		$('.add-dayoff-ok').on('click', function() {
			//ceate oblect variable.
			var inputValue = {};
			//Find element's `dataType` and element's `value`.
			$(this).parent().find('input').each(function(){
				//Push element's `dataType` and `value` to object.
				inputValue[$(this).data('type')] = $(this).val();
				inputValue['id'] = $(this).data('id');
			});
			//Send object to `controller` see `controller::updateOffPeople()`.
			$.post('?action=updateOffPeople&year=<?php echo $thisYear;?>', inputValue);
		});
		//Save all setting
		$('.addAll').on('click', function() {
			var allData = {};
			$('table.list-to-add tr td').find('input').each(function() {
				allData[$(this).data('type')] = $(this).val();
				allData['id'] = $(this).data('id');
				$.post('?action=updateOffPeople&year=<?php echo $thisYear;?>', allData);
			});
			alert('แก้ไขข้อมูลทุกเรคอร์ดเรียบร้อยแล้ว');
		});
	});
</script>