<?php
/* @var $this PromoController */
/* @var $model Promo */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'promo-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php // echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'promo_name'); ?>
		<?php echo $form->textField($model,'promo_name',array('size'=>44,'maxlength'=>44)); ?>
		<?php echo $form->error($model,'promo_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'promo_code'); ?>
		<?php echo $form->textField($model,'promo_code',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'promo_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'amount_off'); ?>
		<?php echo $form->textField($model,'amount_off', array('placeholder'=>'$0.00')); ?>
		<?php echo $form->error($model,'amount_off'); ?>
	</div>

	<div class="row">
		<?php 
		$arr_months = array();
		for($m=1;$m<=12;$m++) {
		    $arr_months[$m] = $m;
		}
		?>
		<?php echo $form->labelEx($model,'valid_num_months'); ?>
		<?php echo $form->dropDownList($model,'valid_num_months', $arr_months); ?>
		<?php echo $form->error($model,'valid_num_months'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status', EnumStatus::lists(), array('empty'=>'(select)')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->