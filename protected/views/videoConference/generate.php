<?php
$this->page_label = "Video Conference - Set Schedule";
?>

<div class="col-md-12">
	<div class="col-md-6 form" style="border-right: 1px solid lightgray;">
			<div class="row">

				<?php if ($customer != null): ?>
				<ul class="nav nav-tabs">
				    <li class="active"><a data-toggle="tab" href="#appointment">Appointment</a></li>
					<li><a data-toggle="tab" href="#primary">Primary Information</a></li>
					<li><a data-toggle="tab" href="#secondary">Secondary Information</a></li>
				</ul>

				<div class="tab-content">
					<div id="appointment" class="tab-pane fade in active">
						<?php if ($appointment != null): ?>
						<table class="table table-bordered">
							<tr>
								<td class="alert-info2" width="20%">Date: </td>
								<td><?php echo date('m/d/Y', strtotime($appointment->appointment_date)); ?></td>
							</tr>
							<tr>
								<td class="alert-info2" width="20%">Time: </td>
								<td><?php echo $appointment->appointment_time; ?></td>
							</tr>
							<tr>
								<td class="alert-info2" width="20%">Location: </td>
								<td><?php echo $appointment->location; ?></td>
							</tr>
						</table>
						<?php endif; ?>
					</div>
					<div id="primary" class="tab-pane fade">
							<table class="table table-bordered">
								<tbody>
								<tr>
									<td class="alert-info2" width="20%">Name: </td><td><?php echo $customer->primary_firstname.' '.$customer->primary_lastname; ?></td>
								</tr>
								<tr>
									<td class="alert-info2" width="20%">Telephone: </td><td><?php echo $customer->primary_telno; ?></td>
								</tr>
								<tr>
									<td class="alert-info2" width="20%">Mobile: </td><td><?php echo $customer->primary_cellphone; ?></td>
								</tr>
								<tr>
									<td class="alert-info2" width="20%">Alt Telephone: </td><td><?php echo $customer->primary_alt_telno; ?></td>
								</tr>
								<tr>
									<td class="alert-info2" width="20%">Email: </td><td><?php echo $customer->primary_email; ?></td>
								</tr>
								<tr>
									<td class="alert-info2" width="20%">Emergency Contact: </td><td><?php echo $customer->primary_emergency_contact; ?></td>
								</tr>
								</tbody>
							</table>
					</div>
					<div id="secondary" class="tab-pane fade">
							<table class="table table-bordered">
								<tr>
									<td class="alert-info2" width="20%">Name: </td><td><?php echo $customer->secondary_firstname.' '.$customer->secondary_lastname; ?></td>
								</tr>
								<tr>
									<td class="alert-info2" width="20%">Telephone: </td><td><?php echo $customer->secondary_telno; ?></td>
								</tr>
								<tr>
									<td class="alert-info2" width="20%">Mobile: </td><td><?php echo $customer->secondary_cellphone; ?></td>
								</tr>
								<tr>
									<td class="alert-info2" width="20%">Alt Telephone: </td><td><?php echo $customer->secondary_alt_telno; ?></td>
								</tr>
								<tr>
									<td class="alert-info2" width="20%">Email: </td><td><?php echo $customer->secondary_email; ?></td>
								</tr>
								<tr>
									<td class="alert-info2" width="20%">Emergency Contact: </td><td><?php echo $customer->secondary_emergency_contact; ?></td>
								</tr>
								</tbody>
							</table>
					</div>
				</div>
				<?php endif; ?>
				<hr>
			</div>

			<!-- Button links -->
			<div class="row">
				<table class="table table-striped">
					<tbody>
						<tr>
						<td colspan="10" class="alert-info2">
							Coverage Insights Links:<br>
							<ul>
								<li><a href="<?php echo $this->programURL() . '/agentprep/step_customer1?customer_id='. $customer->id .'&start=true'; ?>" target="_blank">Agent Prep (AP)</a></li>
								<li><a href="<?php echo $this->programURL() . '/needassessment/step_customer1?customer_id='. $customer->id .'&start=true'; ?>" target="_blank">Needs Assessment (NA)</a></li>
								<li><a href="<?php echo $this->programURL() . '/cir/step_customer1?customer_id='. $customer->id .'&start=true'; ?>" target="_blank">Customer Review (CIR)</a></li>
								<li><a href="#!" onclick="showReport('<?php echo $this->programURL(); ?>/reports/renderpdf?report_name=cir&report_type=basic&customer_id=<?php echo $customer->id; ?>')">CIR Report</a></li>
							</ul>
						</td>
						</tr>
					</tbody>
				</table>
			</div>
	</div>

	<div class="col-md-6 form">
		
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'videoconference-generate-form',
			'enableAjaxValidation'=>false,
		)); ?>
		<!-- New schedule conference -->
		<div class="newform row" style="display:none;">
			<?php echo $form->errorSummary($model); ?>
			<p class="note">
				<span>Fields with <span class="required">*</span> are required.</span>
				<span style="float:right;">[System will automatically remind agent 1-hour before the video call schedule]</span>
			</p>

			<div class="row">
				<div class="col-md-6">
					<?php echo $form->labelEx($model,'sched_date'); ?>
					<?php echo $form->textField($model,'sched_date', array('value'=>date('m/d/Y'),'class'=>'datepicker')); ?>
					<?php echo $form->error($model,'sched_date'); ?>
				</div>
				<div class="col-md-6">
					<?php echo $form->labelEx($model,'sched_time'); ?>
					<?php
						echo $form->textField($model, 'sched_time', array('value'=>date("H:i"))); 
					?>
					<?php echo $form->error($model,'sched_time'); ?>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
				<?php echo $form->labelEx($model,'remarks'); ?>
				<?php echo $form->textField($model,'remarks'); ?>
				<?php echo $form->error($model,'remarks'); ?>
				</div>
			</div>

			<div class="row buttons">
				<div class="col-md-12">
					<table>
						<tr>
							<td><?php echo CHtml::submitButton('Save Schedule', array('class'=>'btn btn-primary')); ?></td>
							<td><button type="button" class="btn btn-primary btncancel">Cancel</button></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<?php $this->endWidget(); ?>

		<button type="button" class="btn btn-primary btn-sm move-right btnnewsched"><i class="fa fa-plus"></i> New Schedule</button>
		<h4><i class="fa fa-calendar"></i> Scheduled Video Conference</h4>
		<table class="table table-bordered table-hover">
			<thead>
				<tr class="text-left">
					<th><b>Created Date</b></th>
					<th><b>Schedule Date</b></th>
					<th><b>Schedule Time</b></th>
					<th><b>Notes</b></th>
					<th><b><i class="fa fa-phone"></i> Conference Action</b></th>
				</tr>
			</thead>
			<tbody>

				<?php if(!empty($record)): ?>
				<?php foreach($record as $k=>$v): ?>
				<?php 
				$a = date('m/d/Y', strtotime($v->sched_date));
				$b = date('m/d/Y');
				$row_class = '';
				if ($a == $b) {
					$row_class = 'alert-success';
				}
				else if( strtotime($a) > strtotime('now')) {
					$row_class = 'alert-info';
				} 
				else if( strtotime($a) < strtotime('now')) {
					$row_class = 'alert-danger';
				} 
				
				// Check status if done
				if ($v->status == 'done') {
					$row_class = 'alert-info';
				}
				?>
				<tr class="<?php echo $row_class; ?>">
				    <td><?php echo date('m/d/Y', strtotime($v->created_at)); ?></td>
					<td><?php echo date('m/d/Y', strtotime($v->sched_date)); ?></td>
					<td><?php echo $v->sched_time; ?></td>
					<td><?php echo $v->remarks; ?></td>
					<td>
						<?php
							// Check if date is equal to current date
							if ($a == $b) { 
								$setstatus = $this->programURL() .'/videoConference/statusdone?id='. $v->id . '&customer_id='.$v->customer_id;
								$resend = $this->programURL() .'/videoConference/resend?id='. $v->id . '&customer_id='. $v->customer_id;
								$agencyviewer_url = $this->programURL() .'/videoConference/agencyviewer'. $v->generated_url;
								echo '<table>';
								echo '<tr>';
								if ($v->status != 'done') {
									echo '<td><a href="'. $agencyviewer_url .'" class="btn btn-success btn-xs">Open</a></td>';
									echo '<td><a href="'. $resend .'" class="btn btn-info btn-xs">Resend</a></td>';
									echo '<td><a href="'. $setstatus .'" class="btn btn-danger btn-xs"  onclick="return confirm(\'Are you sure to set this to done?\')">Done</a></td>';
								} else {
									echo '<td>Completed</td>';
								}
								echo '</tr>';
								echo '</table>';
							} 
							else if( strtotime($a) > strtotime('now')) {
								echo '<i class="fa fa-check-circle"></i> Scheduled';
							} 
							else if( strtotime($a) < strtotime('now')) {
								echo '<i class="fa fa-exclamation-triangle"></i> Past Due: ' . $a;
							} 
						?>
					</td>
				</tr>
				<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div><!-- end: col-md-12 -->

<script src="<?php echo $this->programURL(); ?>/js/pages/generate.js" async></script>