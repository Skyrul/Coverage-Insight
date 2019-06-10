<?php
if ($model == null) {
	echo 'No record';
	exit;
}
?>

<a href="<?php echo $this->programURL(); ?>/feedback/viewall" class="btn btn-default">Back to listing</a>
<p>&nbsp;</p>

<table style="width: 100%">
<tr>
	<td><strong>URL:</strong></td>
	<td><?php echo $model->page_url; ?></td>
</tr>
<tr>
	<td><strong>Email:</strong></td>
	<td><?php echo $model->reporter_email; ?></td>
</tr>
<tr>
	<td><strong>Date:</strong></td>
	<td><?php echo date('m/d/Y', strtotime($model->created_at)); ?></td>
</tr>
<tr>
	<td><strong>Status:</strong></td>
	<td><?php echo $model->status; ?></td>
</tr>
<tr>
	<td colspan="10">&nbsp;<br></td>
</tr>
<tr>
	<td colspan="10"><strong>Message:</strong></td>
</tr>
<tr>
	<td colspan="10" style="color:red;"><?php echo $model->message; ?></td>
</tr>
<tr>
	<td colspan="10">&nbsp;<br></td>
</tr>

<tr>
	<td colspan="10">Attachment(s)</td>
</tr>
<tr>
	<td colspan="10">
		<ul>
			<?php
			if(!empty($attachments)) {
				foreach($attachments as $k=>$v){
					echo '<li>';
					echo ' <a href="'. $this->programURL() .'/feedback/'. $v->attachment .'">'. $v->attachment .'</a>';
					echo '</li>';
				}
			} else {
				echo '<li>None</li>';
			}
			?>
		</ul>
	</td>
</tr>
<tr>
	<td colspan="10">
		<?php
		if ($model->status == 'REVIEW') {
			echo '<fieldset>';
			echo '<legend>Change Status</legend>';
			echo '<a href="'. $this->programURL() .'/feedback/changestatus?id='. $model->id .'&status=close" class="btn btn-primary">Set to Close</a>';
			echo '<a href="'. $this->programURL() .'/feedback/changestatus?id='. $model->id .'&status=open" class="btn btn-warning">Set to Open</a>';
			echo '</fieldset>';
		}
		?>
	</td>
</tr>

</table>
<br>
<p>Note: For your comments on this feedback, please email it to Engagex system administrator</p>