<?php /*$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'label'=>'URL &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
			'value'=>$model->page_url
		),
		array(
			'label'=>'Email',
			'value'=>$model->reporter_email
		),
		array(
			'label'=>'Date',
			'value'=>date('m/d/Y', strtotime($model->created_at))
		),
		'message',
		'status',
	),
));*/ 

if ($model == null) {
	echo 'No record';
	exit;
}

?>
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
	<td colspan="10">
	<strong>Attachment(s):</strong><br>
	<?php
	$attachments = FeedbackAttachment::model()->findAll('feedback_id = :id', array(
		':id'=>$model->id
	));
	if(!empty($attachments)) {
		foreach($attachments as $kk=>$vv){
			echo '<a href="'. $this->programURL() .'/feedback/'. $vv->attachment .'">'. $vv->attachment .'</a><br>';
		}
	}
	?>
	</td>
</tr>

</table>