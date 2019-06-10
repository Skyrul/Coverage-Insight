<h1>Feedback Items (<?php echo count($model); ?>)</h1>

<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th class="col-xs-1">ID</th>
			<th class="col-xs-6">Message</th>
			<th class="col-xs-1">Status</th>
			<th class="col-xs-1">Created</th>
			<th class="col-xs-1">Attachment</th>
			<th class="col-xs-1">Option</th>
		</tr>
	</thead>
	<tbody>
		<?php if(!empty($model)): ?>
		<?php foreach($model as $k=>$v): ?>
		<?php
			$coloring = '';
			switch(strtoupper($v->status)) {
				case "OPEN":
				$coloring = 'background-color: lime;color:black;';
					break;
				case "CLOSED":
					$coloring = 'background-color: lightgray;';
					break;
				case "UNRESOLVED":
					$coloring = 'background-color: brown; color: yellow;';
					break;
				case "PENDING":
					$coloring = 'background-color: blue; color: white;';
					break;
			}
		?>
		<tr>
			<td><?php echo $v->id; ?></td>
			<td><?php echo $v->message; ?></td>
			<td  style="<?php echo $coloring; ?>"><?php echo strtoupper($v->status); ?></td>
			<td><?php echo date('m/d/Y H:i', strtotime($v->created_at)); ?></td>
			<td>
				<?php
				$attachments = FeedbackAttachment::model()->findAll('feedback_id = :id', array(
					':id'=>$v->id
				));
				if(!empty($attachments)) {
					$ctr=0;
					foreach($attachments as $kk=>$vv){
						$ctr++;
						echo '<a href="'. $this->programURL() .'/feedback/'. $vv->attachment .'">'. $vv->attachment .'</a><br>';
					}
				}
				?>
			</td>
			<td>
				<a href="<?php echo $this->programURL(); ?>/feedback/view/<?php echo $v->id; ?>">Manage</a>
			</td>
		</tr>
		<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
</table>