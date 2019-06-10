<?php
	// action buttons 
	$im  = '<form id="frm-upload" action="'. $this->programURL() .'/customer/import" method="post" enctype="multipart/form-data">';
	$im .= '<input type="file" name="file" id="file_import" style="display:none">';
	$im .= '<button id="btn-browse-file" type="button" class="btn btn-primary" onclick="open_browse_file();">';
	$im .= '   <i class="fa fa-upload"></i> Import';
	$im .= '</button>&nbsp;&nbsp;';
	$im .= '<button id="btn-import" type="button" class="btn btn-success" onclick="open_file_upload();" style="display:none;">';
	$im .= '   <i class="fa fa-upload"></i> Confirm Import';
	$im .= '</button>&nbsp;&nbsp;';
	$im .= '<button id="btn-addgrid" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Customer</button>';
	$im .= '</form>';
    array_push($this->action_buttons, $im);
	

	// page label
	$this->page_label = 'Customer Listing';
	
	// remove goto menu
	$this->goto_menu = false;

	// generate form
	$form=$this->beginWidget('CActiveForm', array(
		'id'=>'customer-form',
		'enableAjaxValidation'=>false,
		'htmlOptions'=>array(
		    'onsubmit'=>'return false;',
		    'onkeypress'=>'return form_autosave(event.keyCode)'
		),
	));
?>

<style>
a.badge {
    font-size: 18px;
}
.is-filtered {
    width: 330px;
    padding: 0px 10px 8px 10px;
}
</style>

<?php if (count($_GET) > 0): ?>
<div class="is-filtered">
    <a class="btn btn-default btn-primary" href="/customer/listing">View All Action Items</a><br>
</div>
<?php endif; ?>

<?php echo $form->hiddenField($model, "account_id", array("value"=> Yii::app()->session["account_id"])); ?>
<table class="datagrid table table-bordered">
	<thead>
		<tr>
			<th class="col-md-2">First Name </th>
			<th class="col-md-2">Last Name </th>
			<th class="col-md-1">Next Appt </th>
			<th class="col-md-1">Last CIR </th>
			<th class="col-md-1 text-center">Open Action Items</th>
			<th class="col-md-6">CIR Progress </th>
		</tr>
	</thead>
	<tbody>
		<?php
		if (count($results) > 0) {
			foreach($results as $row) {
			?>
				<tr data-keyid="<?php echo CHtml::encode($row['id']); ?>" data-json='<?php echo CJSON::encode($row); ?>'>
					<td><?php echo CHtml::encode($row['fname']); ?></td>
					<td><?php echo CHtml::encode($row['lname']); ?></td>
                    <td style="width:130px;"><?php echo CHtml::encode($row['next_appoinment']); ?></td>
                    <td style="width:130px;"><?php echo CHtml::encode($row['last_completed_cir']); ?></td>
                    <td>
                        <div class="text-center" style="width:148px;">
                            <a class="badge" <?php echo ($row['outstanding_action_items'] != "0") ? 'style="background-color:red;"' : ''; ?> href="/account/action_item?cmd=OPEN_ACTION_ITEM_BY&customer_id=<?php echo $row['id']; ?>">
                                <?php echo CHtml::encode($row['outstanding_action_items']); ?>
                            </a>
                        </div>
                    </td>
					<td>
						<?php
						    $btn_ap = $row['ap_status'];
							$btn_ap_href = Yii::app()->request->baseUrl .'/agentprep/step_customer1?customer_id='. CHtml::encode($row['id']) . '&start=true';
							
							$btn_na = $row['na_status'];
							$btn_na_href = ($row['na_status'] != 'btn-norecord') ? Yii::app()->request->baseUrl .'/needassessment/step_customer1?start=true&customer_id='. CHtml::encode($row['id']) : '';
							
							$btn_cir = $row['cir_status'];
							// $btn_cir_href = ($row['cir_status'] != 'btn-norecord') ? Yii::app()->request->baseUrl .'/cir/step_customer1?start=true&customer_id='. CHtml::encode($row['id']) : '';
							$btn_cir_href = Yii::app()->request->baseUrl .'/cir/step_customer1?start=true&customer_id='. CHtml::encode($row['id']);
							
							$btn_report_href = ($row['next_appoinment']!='') ? Yii::app()->request->baseUrl .'/reports/renderpdf?report_name=cir&report_type=basic&customer_id='. CHtml::encode($row['id']) : '';
							$btn_referrals = Yii::app()->request->baseUrl .'/cir/step_referrals?customer_id='. CHtml::encode($row['id']);
						?>
						<a class="btn btn-tran-AP btn-sm <?php echo $btn_ap; ?>" href="<?php echo $btn_ap_href; ?>">Agent Prep</a>
						<a class="btn btn-tran-NA btn-sm <?php echo $btn_na; ?>" href="<?php echo $btn_na_href; ?>">Needs Assessment</a>
						<a class="btn btn-tran-CIR btn-sm <?php echo $btn_cir; ?>" href="<?php echo $btn_cir_href; ?>">CIR</a>
						
                                                
						<button class="btn btn-sm btn-report" onclick="showReport('<?php echo $btn_report_href; ?>')">Reports</button>
						<a class="btn btn-warning btn-sm" href="<?php echo $btn_referrals; ?>">Referrals</a>
						<button class="btn btn-default btn-sm btn-deletegrid" data-id="<?php echo CHtml::encode($row['id']); ?>"><i class="fa fa-close"></i></button>
					</td>
				</tr>
		    <?php
		    }
		}
	    ?>
	</tbody>
</table>
<?php $this->endWidget(); ?>


<?php
Yii::app()->clientScript->registerScriptFile(
	Yii::app()->baseUrl . '/js/pages/listing.js',
	CClientScript::POS_END
); ?>
<script type="text/javascript">
app.input_fields = [
		// First name
		'<?php
		echo $form->textField($model,"primary_firstname", array(
		      "size"=>45,
		      "maxlength"=>45,
		      "class"=>"form-control",
		      "placeholder"=>"First Name",
		      "autocomplete"=>"off",
		 )); ?>',

		// Last name
		'<?php
		echo $form->textField($model,"primary_lastname", array(
		      "size"=>45,
		      "maxlength"=>45,
		      "class"=>"form-control",
		      "placeholder"=>"Last Name",
		      "autocomplete"=>"off",
		)); ?>',

		'',
		'',
		'',
		'<button class="btn btn-primary" onclick="form_autosave(13)">Save</button>',
];
</script>
