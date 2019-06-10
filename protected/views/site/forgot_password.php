<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>
	<div class="form">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'forgot-password-form',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	)); ?>

		<img class="img-responsive account-logo-login" src="<?php echo Yii::app()->request->baseUrl; ?>/images/program.png">
		<br>

		<?php
		    foreach(Yii::app()->user->getFlashes() as $key => $message) {
		        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
		    }
		?>

		<div class="col-xs-12">
			<div class="row">
				<label>Enter Your Email Address:</label>
				<?php echo $form->textField($model,'email', array('class'=>'form-control', 'placeholder'=>'Email', 'autocomplete'=>'off')); ?>
				<?php echo $form->error($model,'username'); ?>
			</div>
		</div>

		<div class="col-xs-12">
			<div class="row buttons">
				<?php echo CHtml::submitButton('Send', array('class'=>'btn btn-warning btn-block')); ?>
				<a href="/site/login" class="btn btn-default btn-block btn-sm">Back to Login</a>
			</div>
		</div>

	<?php $this->endWidget(); ?>
	</div><!-- form -->