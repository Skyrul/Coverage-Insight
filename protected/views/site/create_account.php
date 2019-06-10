<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - Create an account';
?>
<style>
.container {
    width: 98% !important;
}
div.form .errorMessage {
    font-size: 0.82em !important;
}
.label-group {
    color: #ff921c;
    border-bottom: 1px dotted;
}
.where-is {
    padding-top: 8px;
}
img.img-responsive.account-logo-login {
    margin: 0 auto;
    width: 20%;
}
.red {
    font-size: 11px;
    color:red;
}
.chkbox {
    width: 16px;
    height: 16px;
}
.agree-form {
    background-color: #f6f6f6;
    color: black;
}

/* override form */
.form {
    border: 1px solid #004171;
    border-radius: 8px;
    padding: 10px;
    -webkit-box-shadow: 0px 10px 36px -8px rgba(51,38,0,0.64);
    -moz-box-shadow: 0px 10px 36px -8px rgba(51,38,0,0.64);
    box-shadow: 0px 10px 36px -8px rgba(51,38,0,0.64);
    Copy Text: ;
}

</style>

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

		<?php
		    foreach(Yii::app()->user->getFlashes() as $key => $message) {
		        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
		    }
		?>
		

        <table>
        	<tr valign="top">
        		<!-- First Column -->
        		<td class="col-xs-4">
            		<div class="col-xs-12">
            			<div class="row">
            				<h4 class="label-group">Account Registration</h4>
            			</div>
            		</div>
            
            		<div class="col-xs-12">
            			<div class="row">
            				<label>Agency Name:<span class="red">*</span></label>
            				<?php echo $form->textField($model,'agency_name', array('class'=>'form-control', 'placeholder'=>'', 'autocomplete'=>'off')); ?>
            				<?php echo $form->error($model,'agency_name'); ?>
            			</div>
            		</div>

            		<div class="col-xs-12">
            			<div class="row">
            				<label>First Name:<span class="red">*</span></label>
            				<?php echo $form->textField($model,'first_name', array('class'=>'form-control', 'placeholder'=>'', 'autocomplete'=>'off')); ?>
            				<?php echo $form->error($model,'first_name'); ?>
            			</div>
            		</div>
            		
            		<div class="col-xs-12">
            			<div class="row">
            				<label>Last Name:<span class="red">*</span></label>
            				<?php echo $form->textField($model,'last_name', array('class'=>'form-control', 'placeholder'=>'', 'autocomplete'=>'off')); ?>
            				<?php echo $form->error($model,'last_name'); ?>
            			</div>
            		</div>
            
            		<div class="col-xs-12">
            			<div class="row">
            				<label>Email Address:<span class="red">*</span></label>
            				<?php echo $form->textField($model,'email', array('class'=>'form-control', 'placeholder'=>'', 'autocomplete'=>'off')); ?>
            				<?php echo $form->error($model,'email'); ?>
            			</div>
            		</div>
            
            		<div class="col-xs-12">
            			<div class="row">
            				<label>Password:<span class="red">*</span></label>
            				<?php echo $form->passwordField($model,'password', array('class'=>'form-control', 'placeholder'=>'', 'autocomplete'=>'off')); ?>
            				<?php echo $form->error($model,'password'); ?>
            			</div>
            		</div>
            		
            		<div class="col-xs-12">
            			<div class="row">
            				<label>Confirm Password:<span class="red">*</span></label>
            				<?php echo $form->passwordField($model,'confirm_password', array('class'=>'form-control', 'placeholder'=>'', 'autocomplete'=>'off')); ?>
            				<?php echo $form->error($model,'confirm_password'); ?>
            			</div>
            		</div>
            			
        		</td><!-- End:First Column -->
        		
        		<!-- Second Column -->
        		<td class="col-xs-4">
            		<div class="col-xs-12">
            			<div class="row">
            				<h4 class="label-group">Billing Information</h4>
            			</div>
            		</div>
            
            		<div class="col-xs-12">
            			<div class="row">
            				<label>Name On Card:<span class="red">*</span></label>
            				<?php echo $form->textField($model,'cc_cardname', array('class'=>'form-control', 'placeholder'=>'', 'autocomplete'=>'off')); ?>
            				<?php echo $form->error($model,'cc_cardname'); ?>
            			</div>
            		</div>
            
            
            		<div class="col-xs-12">
            			<div class="row">
            				<label>Card Type:<span class="red">*</span></label>
            				<?php echo $form->dropDownList($model,'cc_cardtype', CardProviderFacade::lists(), array('empty'=>'(select)','class'=>'form-control', 'placeholder'=>'', 'autocomplete'=>'off')); ?>
            				<?php echo $form->error($model,'cc_cardtype'); ?>
            			</div>
            		</div>
            
            		<div class="col-xs-12">
            			<div class="row">
            				<label>Credit Card Number:<span class="red">*</span></label>
            				<?php echo $form->textField($model,'cc_cardnum', array('class'=>'form-control', 'placeholder'=>'0000 0000 0000 0000', 'autocomplete'=>'off')); ?>
            				<?php echo $form->error($model,'cc_cardnum'); ?>
            			</div>
            		</div>
            		
            		<div class="row">
                		<div class="col-xs-4">
                				<label>CVC:<span class="red">*</span></label>
                				<?php echo $form->textField($model,'cc_cvc', array('class'=>'form-control', 'placeholder'=>'', 'autocomplete'=>'off')); ?>
                				<?php echo $form->error($model,'cc_cvc'); ?>
                		</div>
                		<div class="col-xs-8">
                			<label>&nbsp;</label>
                			<div class="where-is"><a href="https://www.cvvnumber.com/cvv.html" target="_blank">Where is my 3 digit CVC code?</a></div>
                		</div>
            		</div>
            		
            		<div class="row">
            			<div class="col-xs-6">
            				<label>Expire Date:<span class="red">*</span></label>
            				<?php
            				$arr_month = array();
            				for ($i = 1;$i <= 12;$i++) {
            				    $arr_month[$i] = date('F', mktime(0, 0, 0, $i, 10));
            				}
            				?>
            				<?php echo $form->dropDownList($model,'cc_expiry_month', $arr_month, array('empty'=>'(month)', 'class'=>'form-control')); ?>
            				<?php echo $form->error($model,'cc_expiry_month'); ?>
            			</div>
            			<div class="col-xs-6">
            				<label>&nbsp;</label>
            				<?php
            				$arr_year = array();
            				for ($i = (int)date('Y');$i <= 2032;$i++) {
            				    $arr_year[$i] = $i;
            				}
            				?>
            				<?php echo $form->dropDownList($model,'cc_expiry_year', $arr_year, array('empty'=>'(year)','class'=>'form-control', 'placeholder'=>'', 'autocomplete'=>'off')); ?>
            				<?php echo $form->error($model,'cc_expiry_year'); ?>
            			</div>
            		</div>
            		
        		</td><!-- End:Second Column -->
        		
        		<!-- Third Column -->
        		<td class="col-xs-4">
            		<div class="col-xs-12">
            			<div class="row">
            				<h4 class="label-group">Additional Information</h4>
            			</div>
            		</div>
            		
            		<div class="col-xs-12">
            			<div class="row">
            				<label>Address:<span class="red">*</span></label>
            				<?php echo $form->textField($model,'bill_address', array('class'=>'form-control', 'placeholder'=>'', 'autocomplete'=>'off')); ?>
            				<?php echo $form->error($model,'bill_address'); ?>
            			</div>
            		</div>
            		
            		<div class="col-xs-12">
            			<div class="row">
            				<label>City:<span class="red">*</span></label>
            				<?php echo $form->textField($model,'bill_city', array('class'=>'form-control', 'placeholder'=>'', 'autocomplete'=>'off')); ?>
            				<?php echo $form->error($model,'bill_city'); ?>
            			</div>
            		</div>
            		
            		<div class="col-xs-12">
            			<div class="row">
            				<label>State/Province:<span class="red">*</span></label>
            				<?php echo $form->dropDownList($model,'bill_state', CHtml::listData(USStates::model()->findAll(), 'state_code', 'state_name'), array('empty'=> '(select)', 'class'=>'form-control', 'autocomplete'=>'off')); ?>
            				<?php echo $form->error($model,'bill_state'); ?>
            			</div>
            		</div>
            		
            		<div class="col-xs-12">
            			<div class="row">
            				<label>ZIP/Postal Code:<span class="red">*</span></label>
            				<?php echo $form->textField($model,'bill_zipcode', array('class'=>'form-control', 'placeholder'=>'', 'autocomplete'=>'off')); ?>
            				<?php echo $form->error($model,'bill_zipcode'); ?>
            			</div>
            		</div>
            		
            		<div class="col-xs-12">
            			<div class="row">
            				<label>Phone:<span class="red">*</span></label>
            				<?php echo $form->textField($model,'bill_phone', array('class'=>'form-control phone-mask', 'placeholder'=>'', 'autocomplete'=>'off')); ?>
            				<?php echo $form->error($model,'bill_phone'); ?>
            			</div>
            		</div>
            		
            		<div class="row">
            			<div class="col-xs-8 col-xs-4">
            				<label>Promo Code:</label>
            				<?php 
            				    echo $form->textField($model,'promo_code', array('class'=>'form-control', 'placeholder'=>'', 'autocomplete'=>'off')); 
            				?>
            				<?php echo $form->error($model,'promo_code'); ?>
            			</div>
            		</div>
            		
            		<div class="col-xs-12">
            			<div class="row">
            				<span class="red">
            					<?php echo $form->checkBox($model,'buy_staff', array('class'=>'chkbox')); ?>&nbsp;
            					Check here to add <strong><?php echo ChargesFacade::fees()->staff_credits; ?></strong> Staff Credits for the amount of <?php echo Yii::app()->numberFormatter->formatCurrency(ChargesFacade::fees()->staff_fee, "USD"); ?>:&nbsp;
            				</span>
            			</div>
            		</div>

            		<div class="col-xs-12">
            			<div class="row">
            				<span class="red">
            					<?php echo $form->checkBox($model,'videoconf_feature', array('class'=>'chkbox')); ?>&nbsp;
            					Check here to Enable <strong>Video Conference Feature</strong> for the amount of <?php echo Yii::app()->numberFormatter->formatCurrency(ChargesFacade::fees()->videoconf_feature_fee, "USD"); ?>:&nbsp;
            				</span>
            			</div>
            		</div>
            		
            		<div class="row">
            			<div class="col-xs-12 agree-form">
            				<?php echo $form->checkBox($model,'agree_form', array('class'=>'chkbox')); ?>&nbsp;
            				By creating an account, you are agreeing to our <a href="#">Terms of Service.</a>.
            				<div style="margin-left:20px; padding: 2px; background-color: lightyellow;"><?php echo $form->error($model,'agree_form'); ?></div>
            			</div>
            		</div>
            		
            		<div class="col-xs-12">
            			<div class="row buttons">
            				<?php echo CHtml::submitButton('Complete this Registration', array('class'=>'btn btn-warning btn-block')); ?>
            				<a href="/site/login" class="btn btn-default btn-block btn-sm"><i class="fa fa-arrow-left"></i>&nbsp;Back to Login</a>
            			</div>
            		</div>
        		</td><!-- End:Third Column -->
        	</tr>
        	
        </table>

	<?php $this->endWidget(); ?>
	</div><!-- form -->
	
	<script>
	$(document).ready(function() {
		$('#CreateAccountForm_cc_cvc').attr('maxlength', 3);
		$('#CreateAccountForm_cc_cardtype').change(function(e) {
			e.preventDefault();
			var cvc = $('#CreateAccountForm_cc_cvc');
			var ttype = this.value;
			var lngth = 3;
			if (ttype === 'American Express')
			{
				lngth = 4;
			}
			var trrm = cvc.val();
			cvc.val(trrm.substr(0, lngth));
			cvc.attr('maxlength', lngth);
		});
	});
	
	</script>
	