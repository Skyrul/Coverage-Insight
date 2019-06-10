<style>
.text-control {
    width: 96% !important;
}
.tr-head {
    background-color: #f7f5f5;
}
.default-card {
    color: green;
}
.errorMessage {
    color: red;
}
</style>

<div class="row">
	<div style="width: 47%;">
		<button id="btn-new-card" class="btn btn-warning btn-sm pull-right">Add New</button>
	</div>
</div>

<div class="row">
	<table class="table table-bordered" style="width: 52%;margin-left: -28px;">
		<tr class="tr-head">
			<td>Default</td>
			<td>Type</td>
			<td>Card Number</td>
			<td>CIM Profile</td>
			<td>Created</td>
			<td>Options</td>
		</tr>
		
		
		<?php 
		if(count($creditcardsettings)>0):
		foreach($creditcardsettings as $k=>$v): 
		?>
		<tr>
			<td><?php echo ($v['is_primary']==EnumCardStatus::PRIMARY) ? '<span class="default-card"><i class="fa fa-check-circle fa-2x" aria-hidden="true"></i></span>':''; ?></td>
			<td><?php echo $v['card_type']; ?></td>
			<td><?php echo $v['credit_card']; //$this->ccMasking($v['credit_card'], 4); ?></td>
			<td><?php echo $v['cim_customer_profile_id']; ?></td>
			<td><?php echo date('m/d/Y', strtotime($v['created_at'])); ?></td>
			<td>
				<!-- <button data-id="<?php echo $v['id']; ?>" class="btn btn-primary btn-xs btn-edit">Edit</button> -->
				<button data-id="<?php echo $v['id']; ?>" class="btn btn-primary btn-xs btn-delete">Delete</button>
				<button data-id="<?php echo $v['id']; ?>" class="btn btn-primary btn-xs btn-set-as-default">Set as Default</button>
			</td>
		</tr>
		<?php 
		endforeach;
		else:
		?>
		<tr>
			<td colspan="100">No Credit Card(s)</td>
		</tr>
		<?php
		endif;
		?>
	</table>
	
	
</div>

<div id="row-add-card" class="row hide">	
    <?php
    $form= $this->beginWidget('CActiveForm', array(
        'id'=>'credit-card-setting-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    ));
    ?>
    <table style="width: 47%;">
    		<tr>
    			<td colspan="10">
    				<div class="pull-left" style="width: 100%;border-top:1px dotted gray;">&nbsp;</div>
    			</td>
    		</tr>
    		<tr>
    			<td colspan="10">
    				<h4 id="row-add-card-label" class="pull-left">Add New</h4>
    			</td>
    		</tr>
    		<tr>
    			<td colspan="10"><span class="errorMessage"></span></td>
    		</tr>
            <tr>
                <td colspan="2">
                	<?php echo $form->labelEx($model,'card_type'); ?>
                    <?php echo $form->dropDownList($model, 'card_type', CardProviderFacade::lists(), array('empty'=>'(select)','class'=>'text-control form-control', 'placeholder'=>'Type')); ?>
                </td>
            </tr>

            <tr>
                <td colspan="10">
                	<?php echo $form->labelEx($model,'holder'); ?>
                    <?php echo $form->textField($model, 'holder', array('class'=>'text-control form-control', 'placeholder'=>'Name on Card')); ?>
                </td>
            </tr>
            <tr>
                <td colspan="10">
                	<?php echo $form->labelEx($model,'address'); ?>
                    <?php echo $form->textField($model, 'address', array('class'=>'text-control', 'placeholder'=>'Billing Address')); ?>
                </td>
            </tr>
            <tr>
                <td>
                	<?php echo $form->labelEx($model,'city'); ?>
                    <?php echo $form->textField($model, 'city', array('class'=>'text-control', 'placeholder'=>'City')); ?>
                </td>
                <td>
                	<?php echo $form->labelEx($model,'state'); ?>
                    <?php echo $form->textField($model, 'state', array('class'=>'text-control', 'placeholder'=>'State')); ?>
                </td>
                <td>
                	<?php echo $form->labelEx($model,'zip'); ?>
                    <?php echo $form->textField($model, 'zip', array('class'=>'text-control', 'placeholder'=>'ZIP')); ?>
                </td>
            </tr>
            <tr>
                <td colspan="10">
                	<?php echo $form->labelEx($model,'cc_number'); ?>
                    <?php echo $form->textField($model, 'cc_number', array('class'=>'text-control form-control', 'placeholder'=>'Card Number')); ?>
                </td>
            </tr>
            <tr>
                <td>
                	<?php echo $form->labelEx($model,'cc_expiry_month'); ?>
                    <?php echo $form->dropDownList($model, 'cc_expiry_month', CardProviderFacade::date_months(), array('empty'=>'(select)', 'class'=>'text-control', 'placeholder'=>'Exp Month')); ?>
                </td>
                <td>
                	<?php echo $form->labelEx($model,'cc_expiry_year'); ?>
                    <?php echo $form->dropDownList($model, 'cc_expiry_year', CardProviderFacade::date_years(), array('empty'=>'(select)', 'class'=>'text-control', 'placeholder'=>'Exp Year')); ?>
                </td>
                <td>
                	<?php echo $form->labelEx($model,'cc_cvc'); ?>
                    <?php echo $form->textField($model, 'cc_cvc', array('class'=>'text-control', 'placeholder'=>'CVC')); ?>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="10">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="10">
                    <button id="btn-save" type="button" class="btn btn-warning pull-right">Save</button>
                </td>
            </tr>
        </tfoot>
    </table>
   
    
    <?php $this->endWidget(); ?>
</div>

<script>
    function saverecord(e) 
    {
        e.preventDefault;
        var param = $('#credit-card-setting-form').serialize();
        $.post(global_config.base_url + '/creditcardsettings/save', param, function(data) {
            debugger;
        	$('.errorMessage').html(data.json);
            if(data.status=='success') {
                dialogbox('', '', 'hide');
            }
        });
    }
    function close_dialog() 
    {
        $(global_config.dlg).modal('hide')
    }
    
    !(function() {
        $(document).ready(function() {
            $('#btn-save').on('click', saverecord);
			$('#btn-new-card').on('click', function() {
				var rowcard = $('#row-add-card');
				var rowcardlabel = $('#row-add-card-label');
				if(!rowcard.is(':visible')) {
					$(this).text('Hide Form');
				} else {
					$(this).text('Add New');
				}
				rowcard.toggleClass('hide');
			});

			// delete card and in CIM
			$('.btn-delete').on('click', function(e) {
				e.preventDefault();
				var id = $(this).attr('data-id');
				$.post(global_config.base_url + '/creditcardsettings/delete', {'id':id}, function(data) {
					debugger;
					$('.errorMessage').html(data.json);
		            if(data.status=='success') {
			            alertify.alert(data.json);
		                dialogbox('', '', 'hide');
		            }
				});
			});

			// set default card
			$('.btn-set-as-default').on('click', function(e) {
				e.preventDefault();
				var id = $(this).attr('data-id');
				$.post(global_config.base_url + '/creditcardsettings/setdefault?id='+ id, null, function(data) {
					debugger;
					$('.errorMessage').html(data.json);
		            if(data.status=='success') {
			            alertify.alert(data.json);
		                dialogbox('', '', 'hide');
		            }
				});
			});

			// american express is 4 cvc
			$('#CreditCardForm_card_type').change(function() {
				var text = $(this).val();
				var cvc = $('#CreditCardForm_cc_cvc');
				debugger;
				if (text === 'American Express'){
					cvc.attr('maxlength', 4);
				} else {
					cvc.attr('maxlength', 3);
				}
			});
            
            $('.dtpicker').datepicker();
        });
    })();
    </script>