<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Change Password';
?>
	<div class="form">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'create-account-form',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	)); ?>

		<img class="img-responsive account-logo-login" src="<?php echo Yii::app()->request->baseUrl; ?>/images/program.png">
		<br>
		<h4 class="text-center">Change Password</h4>
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
				<label>Email Address:</label>
				<?php echo CHtml::textField('',CHtml::encode($email),array('class'=>'form-control','readonly'=>'true')); ?>
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
				<?php echo CHtml::submitButton('Change Password', array('class'=>'btn btn-warning btn-block')); ?>
				<a href="/site/login" class="btn btn-default btn-block btn-sm">Back to Login</a>
			</div>
		</div>

	<?php $this->endWidget(); ?>
	</div><!-- form -->