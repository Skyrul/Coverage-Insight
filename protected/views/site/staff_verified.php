<?php


$this->pageTitle=Yii::app()->name . ' - Staff Verified';

if(isset($_GET['completed'])):
?>
	<div class="form">

		
		<img class="img-responsive account-logo-login" src="<?php echo Yii::app()->request->baseUrl; ?>/images/program.png">
		<br>
		<br>
		<h2 class="text-center">This Staff Already Verified.</h2>
		<h4 class="text-center">You can start logging-in <a href="/site/login">here</a></h4>

	</div><!-- form -->
<?php 
else:
?>
	<div class="form">

		
		<img class="img-responsive account-logo-login" src="<?php echo Yii::app()->request->baseUrl; ?>/images/program.png">
		<br>
		<br>
		<h2 class="text-center">Staff account now verified!</h2>
		<h4 class="text-center">You can start logging-in <a href="/site/login">here</a></h4>

	</div><!-- form -->
<?php 
endif;
?>