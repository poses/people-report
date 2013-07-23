<?php
	// echo "<pre>";
	// print_r($user);
	// echo "</pre>";
?>
<div class="user-detail">
	<div class="user-desc right">
		<!--
			- User image will read on field : `$user[0]['picture']`;
			- image dimension should be `140 x 140px`.
		-->
		<img src="images/no-photo" alt="<?php echo $user[0]['firstname'] ?>" title="<?php echo $user[0]['firstname'] ?>" class="left">
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
				<span>-</span>
			</p>
			<p>
				<strong>แผนก</strong>
				<span>-</span>
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
		<input type="date" id="userDetailDateFrom" name="startDate" value="<?php echo $startTime; ?>">

		<label for="userDetailDateTo">ถึงวันที่ </label>
		<input type="date" id="userDetailDateTo" name="endDate" value="<?php echo $endTime; ?>">

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
				<th>รวม</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>สิทธิ์การลา</td>
				<td>30</td>
				<td><?php echo $accessTypeLimit[2]['type_limit']; ?></td>
				<td><?php echo $accessTypeLimit[4]['type_limit']; ?></td>
				<td><?php echo $accessTypeLimit[6]['type_limit']; ?></td>
				<td><?php echo ($accessTypeLimit[7]['type_limit']) ?: '0'; ?></td>
				<td><?php echo ($accessTypeLimit[8]['type_limit']) ?: '0'; ?></td>
				<td><?php echo $accessTypeLimit['All']; ?></td>
			</tr>
			<tr>
				<td>ลาไปแล้ว</td>
				<td>20</td>
				<td><?php echo ($lateWithType['off-' . $accessTypeLimit[2]['access_type_id']]) ?: 0; ?></td>
				<td><?php echo ($lateWithType['off-' . $accessTypeLimit[4]['access_type_id']]) ?: 0; ?></td>
				<td><?php echo ($lateWithType['off-' . $accessTypeLimit[6]['access_type_id']]) ?: 0; ?></td>
				<td><?php echo ($lateWithType['off-' . $accessTypeLimit[7]['access_type_id']]) ?: 0; ?></td>
				<td><?php echo ($lateWithType['off-' . $accessTypeLimit[8]['access_type_id']]) ?: 0; ?></td>
				<td><?php echo $countAll; ?></td>
			</tr>
			<tr class="remain-date">
				<td>วันลาคงเหลือ</td>
				<td>10</td>
				<td><?php echo $accessTypeLimit[2]['type_limit'] - ($lateWithType['off-' . $accessTypeLimit[2]['access_type_id']]) ?: 0; ?></td>
				<td><?php echo $accessTypeLimit[4]['type_limit'] - ($lateWithType['off-' . $accessTypeLimit[4]['access_type_id']]) ?: 0; ?></td>
				<td><?php echo $accessTypeLimit[6]['type_limit'] - ($lateWithType['off-' . $accessTypeLimit[6]['access_type_id']]) ?: 0; ?></td>
				<td><?php echo $accessTypeLimit[7]['type_limit'] - ($lateWithType['off-' . $accessTypeLimit[7]['access_type_id']]) ?: 0; ?></td>
				<td><?php echo $accessTypeLimit[8]['type_limit'] - ($lateWithType['off-' . $accessTypeLimit[8]['access_type_id']]) ?: 0; ?></td>
				<td><?php echo $accessTypeLimit['All'] - $countAll ?></td>
			</tr>
			<tr>
				<td>รวม</td>
				<td>0</td>
				<td>0</td>
				<td>0</td>
				<td>0</td>
				<td>0</td>
				<td>0</td>
				<td></td>
			</tr>
		</tbody>
	</table>
</div>
