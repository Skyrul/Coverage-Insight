<?php
/* @var $this VirtualincentivesController */
/* @var $model Virtualincentives */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'Virtualincentives-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	

	<?php // echo $form->errorSummary($model); ?>
	
	<div class="row">
		<?php echo $form->labelEx($model, 'is_sandbox'); ?>
		<?php echo $form->dropDownList($model,'is_sandbox', EnumStatus::vi_environment()); ?>
		<?php echo $form->error($model,'is_sandbox'); ?>
	</div>
	
	
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
            		<?php echo $form->labelEx($model,'username1'); ?>
            		<?php echo $form->textField($model,'username1',array('size'=>44,'maxlength'=>44)); ?>
            		<?php echo $form->error($model,'username1'); ?>
            	</div>
            
            	<div class="row">
            		<?php echo $form->labelEx($model,'password1'); ?>
            		<?php echo $form->textField($model,'password1',array('size'=>44,'maxlength'=>44)); ?>
            		<?php echo $form->error($model,'password1'); ?>
            	</div>
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>
            	<div class="row">
            		<?php echo $form->labelEx($model,'username2'); ?>
            		<?php echo $form->textField($model,'username2',array('size'=>44,'maxlength'=>44)); ?>
            		<?php echo $form->error($model,'username2'); ?>
            	</div>
            
            	<div class="row">
            		<?php echo $form->labelEx($model,'password2'); ?>
            		<?php echo $form->textField($model,'password2',array('size'=>44,'maxlength'=>44)); ?>
            		<?php echo $form->error($model,'password2'); ?>
            	</div>
			</td>
		</tr>
	</table>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->