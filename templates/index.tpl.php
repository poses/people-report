<?php
	echo $pages->display_pages();
	echo "Page $pages->current_page of $pages->num_pages";
?>
<span>
	<?php echo $pages->display_jump_menu(); ?> /
	<?php echo $pages->display_items_per_page(); ?>
</span>
<h2 class="aligncenter">รายงานสรุปการมาทำงาน</h2>

<form action="?action=index" method="GET">
	<input type="date" name="start_date" > ถึง
	<input type="date" name="end_date" >
	<input type="submit" name="submit" value="submit">
</form>

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