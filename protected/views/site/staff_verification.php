<?php


$this->pageTitle=Yii::app()->name . ' - Staff Registration & Verification';
?>
	<div class="form">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'staff-reg-form',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	)); ?>

		<img class="img-responsive account-logo-login" src="<?php echo Yii::app()->request->baseUrl; ?>/images/program.png">
		<br>
		<h2 class="text-center">Staff Registration</h2>
		<?php
		    foreach(Yii::app()->user->getFlashes() as $key => $message) {
		        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
		    }

			if($model->hasErrors()){
			  echo CHtml::errorSummary($model);
			}
		?>

		<div class="col-xs-12">
			<div class="row">
				<label>Agency Name:</label>
				<input type="text" class="form-control" value="<?php echo $setup->agency_name; ?>" disabled />
			</div>
		</div>

		<div class="col-xs-12">
			<div class="row">
				<label>Staff Name:</label>
				<?php echo $form->textField($model,'fullname', array('class'=>'form-control', 'placeholder'=>'', 'disabled'=>true)); ?>
			</div>
		</div>

		<div class="col-xs-12">
			<div class="row">
				<label>Email Address:</label>
				<?php echo $form->textField($model,'email', array('class'=>'form-control', 'placeholder'=>'Email', 'autocomplete'=>'off', 'disabled'=>true)); ?>
			</div>
		</div>

		<div class="col-xs-12">
			<div class="row">
				<label>Password:</label>
				<?php echo $form->passwordField($model,'password', array('class'=>'form-control', 'placeholder'=>'Password', 'autocomplete'=>'off')); ?>
			</div>
		</div>

		<div class="col-xs-12">
			<div class="row buttons">
				<?php echo CHtml::submitButton('Confirm Account', array('class'=>'btn btn-warning btn-block')); ?>
			</div>
		</div>

	<?php $this->endWidget(); ?>
	</div><!-- form -->