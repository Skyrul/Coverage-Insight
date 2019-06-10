<?php
// action buttons
array_push($this->action_buttons,'<button id="btn-printgrid" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>&nbsp;&nbsp;');
array_push($this->action_buttons,'<a href="'. $this->programURL('') .'/accountItem/export_action_item" class="btn btn-primary"><i class="fa fa-download"></i> Export</a>&nbsp;&nbsp;');
array_push($this->action_buttons,'<button id="btn-addgrid" class="btn btn-primary"><i class="fa fa-plus"></i> Add Action Item</button>');

// page label
$this->page_label = 'Action Items';

// remove goto menu
$this->goto_menu = false;

?>

<style>
.select2-container--default {
		width: 100% !important;
}
.is-filtered {
    width: 330px;
    padding: 0px 10px 8px 10px;
}
#new_customer_primary_fname {
    cursor: pointer;
}
</style>

<?php if (count($_GET) > 0): ?>
    <?php if (isset($_GET['customer_id'])): ?>
        <?php
        if ($_GET['cmd'] != 'OPEN_ACTION_ITEMS') {
        ?>
            <div class="is-filtered">
                <a class="btn btn-default btn-primary" href="/account/action_item?cmd=OPEN_ACTION_ITEMS&customer_id=<?php echo CHtml::encode($_GET['customer_id']); ?>">View All Action Items</a><br>
            </div>
        <?php
        }
        ?>
    <?php else:?>
        <div class="is-filtered">
            <a class="btn btn-default btn-primary" href="/account/action_item">View All Action Items</a><br>
        </div>
    <?php endif; ?>
<?php endif; ?>


<table class="datagrid table table-bordered grid-action-item">
	<thead>
		<tr>
			<th class="col-sm-1">Completed</th>
			<th class="col-sm-2">Name</th>
			<th class="col-sm-1">Secondary Name</th>
			<th class="col-sm-1">Owner</th>
			<th class="col-sm-1">Opportunity</th>
			<th class="col-sm-1">Description</th>
			<th class="col-sm-1">Creation Date</th>
			<th class="col-sm-1">Due Date</th>
			<th class="col-sm-1">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php
		if (count($results) > 0):
		foreach($results as $row):
?>
				<tr id="<?php echo 'Form_'.$row['id']; ?>">
					<?php
					echo CHtml::activeHiddenField($model, "id",
							array("value"=>CHtml::encode($row['id']),
					)); ?>
					<td>
					<span style="display: none;" class="hidden-val"><?php echo $row['is_completed']; ?></span>
					<?php
					echo CHtml::activeCheckbox($model,'is_completed',
						array('checked'=>CHtml::encode($row['is_completed']),
							  'row'=>$row['id'],
							  'class'=>'form-control'
					));
// 					echo CHtml::activeHiddenField($model, "customer_id",
// 							array('value'=> CHtml::encode($row['customer_id']),
// 								  'id'=>'customer_id-'. $row['id']
// 					));
					?>
					</td>
					<td>
    					<?php
    // 					echo CHtml::activeTextField($model,'customer_primary_fname',
    // 						array('value'=>CHtml::encode($row['customer_primary_fname']),
    // 							  'id'=>'customer_primary_fname-'.$row['id'],
    // 							  'row'=>$row['id'],
    // 							  'data-browsing'=>'customer',
    // 							  'data-targets'=>'#customer_id-'. $row['id'].','.
    // 							                  '#customer_primary_fname-'. $row['id'].'',
    // 							  'data-select'=>'id,primary_firstname'
    // 					));
                        ?>
    					
    					<?php
    					$_primary_customers = array();
    					$_secondary_customers = array();
    					$cr1 = new CDbCriteria;
    					$cr1->condition = 'account_id = :id';
    					$cr1->params = array(':id'=> Yii::app()->session['account_id'] );
    					$customer_detail = Customer::model()->findAll($cr1);
    					if (!empty($customer_detail)) {
    					    foreach($customer_detail as $k=>$v) {
    					        $_primary_customers[$v->id] = $v->primary_firstname . ' ' . $v->primary_lastname;
    					        $_secondary_customers[$v->id] = $v->secondary_firstname . ' ' . $v->secondary_lastname;
    					    }
    					}
    					echo CHtml::activeDropDownList($model,'customer_id', $_primary_customers,
    						array(
    						    'options'=>array(CHtml::encode($row['customer_id'])=>array('selected'=>'selected')),
    							'row'=>$row['id'],
    						)
    					);
    					?>
					</td>
					<td>
					<?php
					echo CHtml::activeTextField($model,'customer_secondary_fname',
						array('value'=> CHtml::encode($row['customer_secondary_fname']),
							  'readonly'=>true
					));
// 					echo CHtml::activeDropDownList($model,'customer_id', $_secondary_customers,
//     					array(
//         					'options'=>array(CHtml::encode($row['customer_id'])=>array('selected'=>'selected')),
//         					'row'=>$row['id'],
//         					'disabled'=>true
//     					)
// 					);
					?>
					</td>
					<td>
					<?php
					echo CHtml::activeDropDownList($model, 'owner', AccountSetupFunc::owners_array(),
							array('options'=>array(CHtml::encode($row['owner']) => array('selected'=>'selected') ),
								  'row'=>$row['id'],
							)
						 );
					?>
					</td>
					<td>
					<?php
					echo CHtml::activeDropDownList($model,'is_opportunity',
						array('1'=>'Yes','0'=>'No'),
						array(
							'options'=>array($row['is_opportunity']=>array('selected'=>'selected')),
							'row'=>$row['id'],
						)
					);
					?>
					</td>
					<td>
					<?php
					echo CHtml::activeTextField($model,'description',
						array('value'=>CHtml::encode($row['description']),
							  'row'=>$row['id'],
					));
					?>
					</td>
					<td>
					<?php
					echo CHtml::activeTextField($model,'created_date',
							array('value'=>CHtml::encode(
								date('m/d/Y', strtotime($row['created_date']))
							),
							'class'=>'datepicker',
							'row'=>$row['id'],
					));
					?>
					</td>
					<td>
							<?php
							echo CHtml::activeTextField($model,'due_date',
								array('value'=>CHtml::encode(
										date('m/d/Y', strtotime($row['due_date']))
									  ),
									  'class'=>'datepicker',
									  'row'=>$row['id'],
							));
							?>
					</td>
					<td>
						<button class="floating-action-box btn btn-default btn-sm btn-delete" href="/api/actionitem_delete?id=<?php echo $row['id']; ?>"><i class="fa fa-close"></i></button>
					</td>
				</tr>
<?php
			endforeach;
	    endif;
?>

	</tbody>
</table>


<?php
// custom script
Yii::app()->clientScript->registerScriptFile(
	Yii::app()->baseUrl . '/js/pages/action_item.js',
	CClientScript::POS_END
);
?>
<script type="text/javascript">

// method will be called in action_item.js
app.entry_form = function() {
	// clear stored value in memory
	store.remove('browse_selected');

	var sb = new StringBuilder();
	sb.clear();
	// checkbox
	sb.append('<input type="checkbox" id="new_is_completed" name="newitem[is_completed]" class="form-control">'+
			  '<input type="hidden" id="new_customer_id" name="newitem[customer_id]">XX');

	// customer name
	sb.append('<input type="text" id="new_customer_primary_fname" name="newitem[customer_primary_fname]" class="form-control" placeholder="(click to browse)" data-browsing="customer" data-targets="#new_customer_primary_fname" data-focus="" data-select="id,primary_firstname,primary_lastname,primary_email,secondary_firstname,secondary_lastname,secondary_email">XX');

	 // secondary name
	sb.append('<input type="text" id="new_customer_secondary_fname" class="form-control" readonly>XX');

	// owner
	sb.append('<?php echo AccountSetupFunc::owners_string(); ?>XX');

	// opportunity
	sb.append('<select id="new_is_opportunity" name="newitem[is_opportunity]"><option value="1">Yes</option><option value="0" selected>No</option></select>XX');

	// description
	sb.append('<input type="text" id="new_description" name="newitem[description]" class="form-control">XX');

	// creation date
	sb.append('<input type="text" id="new_created_date" name="newitem[created_date]" class="datepicker form-control" value="<?php echo date("m/d/Y"); ?>">XX');

	// due date
	sb.append('<input type="text" id="new_due_date" name="newitem[due_date]" class="datepicker form-control"  value="<?php echo date("m/d/Y"); ?>">XX');

	// status only
	sb.append('<span><button class="btn btn-primary" type="button" onclick="form_autosave(13, this);">Save</button></span>XX');

	app.input_fields = sb.toString().split('XX');
}

</script>
