<?php
if (!$this->is_superuser()):
?>
  <div class="col-sm-12">
  	<p class="text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>&nbsp;No permission to view</p>
  </div>
<?php
exit;
endif; 
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
		<?php echo $form->labelEx($model,'enrollment_fee'); ?>
		<?php echo $form->textField($model,'enrollment_fee',array('placeholder'=>'$0.00')); ?>
		<?php echo $form->error($model,'enrollment_fee'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'staff_fee'); ?>
		<?php echo $form->textField($model,'staff_fee',array('placeholder'=>'$0.00')); ?>
		<?php echo $form->error($model,'staff_fee'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'videoconf_feature_fee'); ?>
		<?php echo $form->textField($model,'videoconf_feature_fee',array('placeholder'=>'$0.00')); ?>
		<?php echo $form->error($model,'videoconf_feature_fee'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'staff_credits'); ?>
		<?php echo $form->textField($model,'staff_credits', array('placeholder'=>'0.00')); ?>
		<?php echo $form->error($model,'staff_credits'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->