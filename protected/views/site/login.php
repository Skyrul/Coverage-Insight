<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
?>

	<div class="form">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'login-form',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	)); ?>

		<img class="img-responsive account-logo-login" src="<?php echo Yii::app()->request->baseUrl; ?>/images/program.png">
		
		<h1 class="text-center">Login</h1>

		<?php
		    foreach(Yii::app()->user->getFlashes() as $key => $message) {
		        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
		    }
		?>
		<div class="col-xs-12">
			<div class="row">
				<?php echo $form->textField($model,'username', array('class'=>'form-control', 'placeholder'=>'Email', 'autocomplete'=>'off')); ?>
				<?php echo $form->error($model,'username'); ?>
			</div>
		</div>

		<div class="col-xs-12">
			<div class="row">
				<?php echo $form->passwordField($model,'password', array('class'=>'form-control', 'placeholder'=>'Password','autocomplete'=>'off')); ?>
				<?php echo $form->error($model,'password'); ?>
				<p class="hint">
					<!-- Hint: You may login with <kbd>demo</kbd>/<kbd>demo</kbd> or <kbd>admin</kbd>/<kbd>admin</kbd>. -->
				</p>
			</div>
		</div>

		<div class="col-xs-12">
			<div class="row rememberMe">
				<div class="pull-left">
				<?php echo $form->checkBox($model,'rememberMe'); ?>
				<?php echo $form->label($model,'rememberMe'); ?>
				<?php echo $form->error($model,'rememberMe'); ?>
				</div>
			</div>
		</div>

		<div class="col-xs-12">
			<div class="row buttons">
				<?php echo CHtml::submitButton('Login', array('class'=>'btn btn-warning btn-block')); ?>
				<?php echo CHtml::button('Create an account', array('href'=>'/site/create_account', 'class'=>'btn btn-primary btn-block btn-md')); ?>
			</div>
			<div class="row buttons">
				<div class="text-center">
				<a href="/site/forgot_password">I forgot my password?</a>
				</div>
			</div>
		</div>

	<?php $this->endWidget(); ?>
	</div><!-- form -->

<?php 
Yii::app()->clientScript->registerScriptFile(
	Yii::app()->baseUrl . '/js/pages/auth.js', 
	CClientScript::POS_END
); ?>