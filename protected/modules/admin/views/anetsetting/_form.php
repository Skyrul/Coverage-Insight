<?php
/* @var $this AnetsettingController */
/* @var $model Anetsetting */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'Anetsetting-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	

	<?php // echo $form->errorSummary($model); ?>
	
	<div class="row">
		<?php echo $form->labelEx($model, 'is_sandbox'); ?>
		<?php echo $form->dropDownList($model,'is_sandbox', EnumStatus::anet_environment()); ?>
		<?php echo $form->error($model,'is_sandbox'); ?>
	</div>
	
<!-- 	<p class="note">Fields with <span class="required">*</span> are required.</p> -->
	
	<table>
		<tr>
			<td style="background-color: #6aff3c;"><h4 class="text-center">Production</h4></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td style="background-color: #ff1957;"><h4 class="text-center">Sandbox</h4></td>
		</tr>
		<tr>
			<td>
            	<div class="row">
            		<?php echo $form->labelEx($model,'api_login_id'); ?>
            		<?php echo $form->textField($model,'api_login_id',array('size'=>44,'maxlength'=>44)); ?>
            		<?php echo $form->error($model,'api_login_id'); ?>
            	</div>
            
            	<div class="row">
            		<?php echo $form->labelEx($model,'transaction_key'); ?>
            		<?php echo $form->textField($model,'transaction_key',array('size'=>44,'maxlength'=>44)); ?>
            		<?php echo $form->error($model,'transaction_key'); ?>
            	</div>
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>
            	<div class="row">
            		<?php echo $form->labelEx($model,'api_login_id2'); ?>
            		<?php echo $form->textField($model,'api_login_id2',array('size'=>44,'maxlength'=>44)); ?>
            		<?php echo $form->error($model,'api_login_id2'); ?>
            	</div>
            
            	<div class="row">
            		<?php echo $form->labelEx($model,'transaction_key2'); ?>
            		<?php echo $form->textField($model,'transaction_key2',array('size'=>44,'maxlength'=>44)); ?>
            		<?php echo $form->error($model,'transaction_key2'); ?>
            	</div>
			</td>
		</tr>
	</table>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->