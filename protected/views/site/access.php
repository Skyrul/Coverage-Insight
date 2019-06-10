<?php
$this->pageTitle=Yii::app()->name . ' - NA Verification';

?>

        <div class="form">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id'=>'verify-form',
                'htmlOptions'=>array(
                    'class'=>'form-horizontal'
                )
            ));
            ?>
		<img class="img-responsive account-logo-login" src="<?php echo Yii::app()->request->baseUrl; ?>/images/program.png">
		
		<h4 class="text-center">Please enter a phone number you verified in Needs Assessment</h4>

		<?php
		    foreach(Yii::app()->user->getFlashes() as $key => $message) {
		        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
		    }
		?>
		<div class="col-xs-12">
			<div class="row">
                                <?php echo $form->textField($model, 'primary_telno', array('class'=>'form-control phone-mask', 'autocomplete'=>'off')); ?>
				<?php echo $form->error($model,'primary_telno'); ?>
			</div>
		</div>


		<div class="col-xs-12">
			<div class="row buttons">
				<?php echo CHtml::submitButton('Verify & Proceed', array('class'=>'btn btn-warning btn-block')); ?>
			</div>
		</div>
            <?php $this->endWidget(); ?>
        </div>