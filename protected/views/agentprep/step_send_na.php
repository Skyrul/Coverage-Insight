<?php
$this->with_progressbar = true;
$this->progress_bar = array('start' => '100', 'end' => '0');
$this->page_label = $customer->primary_firstname . ' ' . $customer->primary_lastname . '' .
        (($customer->secondary_firstname) ? ' & ' . $customer->secondary_firstname . ' ' . $customer->secondary_lastname : '');
?>
<style>
    .title  {
        width: 200px;
        font-size: 1.4em;
        font-weight: bold;
        text-align: left;
        padding: 2px;
    }
    .form-control {
        /*border: 0px;*/
        width: 350px;
        margin-left: 6px;
        border: 1px solid gray;
        margin-bottom: 1em;
    }
    .select2-container--default {
        width: 350px !important;
        margin-left: 6px;
        margin-bottom: 1em;
        border: 1px solid gray;
    }
    .description {
        margin-top: 14px;
        font-size: 1.3em;
    }
    input[type="checkbox"] {
        width: 32px;
        height: 32px;
    }
</style>

<div class="col-xs-12">
    <div class="row">
        <div class="page-sub-label text-center">Send Needs Assessment</div>
    </div>

    <div class="row">
        <div class="col-xs-offset-2 col-xs-8 text-center">
            <table>
                <tr>
                <p class="description">
                    You have completed the Agent Prep portion of the review and all data has been saved.<br>
                    Please select which email address to send the Needs assessment to. The link will be <br>valid for 1 hour after the appointment time:
                </p>
                <p>&nbsp;</p>
                </tr>
            </table>
        </div>
    </div>

    <form action="" method="post">
    	
        <div class="row">
            <div class="col-xs-push-2 col-xs-8 text-left">
            	<div class="col-xs-12">
            		<?php if ($customer->primary_email != '' || (!is_null($customer->primary_email))): ?>
            		<div class="col-xs-12">
            			<span class="title"><?php echo $customer->primary_firstname . ' ' . $customer->primary_lastname; ?></span>
            		</div>
					<div class="col-xs-12">
						<div class="col-xs-offset-2 col-xs-8">
							<h4 style="text-align: left;width: 300px;"><?php echo CHtml::encode($customer->primary_email); ?></h4>
						</div>
						<div class="col-xs-2">
							<input type="checkbox" name="SendTo[primary]" class="">
						</div>
					</div>
					<?php else: ?>
						<h4 class="text-center">No Email set on Primary Contact</h4>
					<?php endif; ?>        		
            	</div>
            </div>
        </div>
        
		<br>
        
        <div class="row">
            <div class="col-xs-push-2 col-xs-8 text-left">
            	<?php if ($customer->secondary_email != ''): ?>
            	<div class="col-xs-12">
            		<div class="col-xs-12">
            			<span class="title"><?php echo $customer->secondary_firstname . ' ' . $customer->secondary_lastname; ?></span>
            		</div>
					<div class="col-xs-12">
						<div class="col-xs-offset-2 col-xs-8">
							<h4 style="text-align: left;width: 300px;"><?php echo CHtml::encode($customer->secondary_email); ?></h4>
						</div>
						<div class="col-xs-2">
							<input type="checkbox" name="SendTo[secondary]" class="">
						</div>
					</div>            		
            	</div>
            	<?php endif; ?>
            </div>
        </div>
        
		<p>&nbsp;</p>
		
        <!-- footer buttons -->
        <div class="col-xs-12" style="margin-top: 2em;margin-bottom:2em;">
            <div class="col-xs-1">
            </div>
            <div class="col-xs-2">
            </div>
            <div class="col-xs-2">
                <button type="button" name="button" class="btn btn-warning btn-block " href="<?php echo Yii::app()->request->baseUrl; ?>/agentprep/step_appointment">Previous</button>
            </div>
            <div class="col-xs-2 my-send">
            	<button type="submit" class="btn btn-warning btn-block">Send</button>
            </div>
            <div class="col-xs-2 my-next">
                <?php echo CHtml::button('Next', array('submit'=>'?direction=next', 'class'=>'btn btn-warning btn-block')); ?>
            </div>
        </div>
    </form>

</div>

<script>
global_config.page_name="<?php echo basename(__FILE__, '.php'); ?>";
</script>

<?php
// custom script
Yii::app()->clientScript->registerScriptFile(
        Yii::app()->baseUrl . '/js/pages/agent_prep.js', CClientScript::POS_END
);
?>

<script>

</script>
