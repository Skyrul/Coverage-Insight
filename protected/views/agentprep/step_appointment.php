<?php
$this->with_progressbar = true;
$this->progress_bar = array('start' => '80', 'end' => '20');
$this->page_label = $customer->primary_firstname . ' ' . $customer->primary_lastname . '' .
        (($customer->secondary_firstname) ? ' & ' . $customer->secondary_firstname . ' ' . $customer->secondary_lastname : '');

function get_browser_name($user_agent)
{
    if (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) return 'Opera';
    elseif (strpos($user_agent, 'Edge')) return 'Edge';
    elseif (strpos($user_agent, 'Chrome')) return 'Chrome';
    elseif (strpos($user_agent, 'Safari')) return 'Safari';
    elseif (strpos($user_agent, 'Firefox')) return 'Firefox';
    elseif (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7')) return 'Internet Explorer';
    
    return 'Other';
}
?>
<style>
    .title  {
        font-size: 1.2em;
        font-weight: bold;
        text-align: left;
        padding: 2px;
    }
    .form-control {
        border: 1px solid gray;
        margin-bottom: 8px !important;
    }
    .btn {
        margin-bottom: 8px !important;
    }
    .select2-container--default {
        margin-bottom: 8px !important;
        border: 1px solid gray;
        <?php
        $browser = get_browser_name($_SERVER['HTTP_USER_AGENT']);
        if ($browser == 'Edge') {
            echo 'width: 312px !important;';
        } else {
            echo 'width: 323px !important;';
        }
        ?>
    }
    
</style>

<div class="col-xs-12">
    <div class="row">
        <div class="page-sub-label text-center">Appointment</div>
    </div>

    <p>&nbsp;</p>

    <?php echo CHtml::beginForm(); ?>
    <?php echo ($model != null) ? CHtml::errorSummary($model) : ''; ?>
    <div class="row">
        <div class="col-xs-offset-4 col-xs-10">
			<div class="row">
				<div class="col-xs-6">
                	<div class="title col-xs-3">Date:</div>
                    <div class="input-group col-xs-8">
                        <?php echo CHtml::textField('Appointment[appointment_date]', ($model != null) ? CHtml::encode(date('m/d/Y', strtotime($model->appointment_date))) : date('m/d/Y'), array('class' => 'datepicker form-control', 'data-trigger'=>'#btn-showcal')); ?>
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default btn-sm" id="btn-showcal"><i class="fa fa-calendar"></i></button>
                        </span>
                    </div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-xs-6">
                	<div class="title col-xs-3">Time:</div>
                    <div class="input-group col-xs-8">
                        <input name="Appointment[appointment_time]" type="text" class="timepicker form-control" value="<?php echo date('h:i A'); ?>">
                        <span class="input-group-btn">
                            <button type="button" onclick="$('.timepicker').focus()" class="btn btn-default btn-sm"><i class="fa fa-clock-o"></i></button>
                        </span>
                    </div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-xs-6">
                	<div class="title col-xs-3">Location:</div>
                    <div class="input-group col-xs-7">
                        <?php if (!is_null($account_setup->apointment_locations) || $account_setup->videoconf_feature == 1): ?>
        
                            <select name="Appointment[location]" class="form-control">
                                <?php
                                // Add "Video Conference" option if its enabled
                                if ($account_setup->videoconf_feature == 1) {
                                    echo '<option value="VideoConference">Video Conference</option>';
                                } else {
                                    echo '<option value=""></option>';
                                }

                                $locations = explode(',', $account_setup->apointment_locations);
                                foreach ($locations as $key => $value):
                                    $is_selected = '';
                                    if ($model != null) {
                                        if ($model->location == $value) {
                                            $is_selected = 'selected';
                                        }
                                    }
                                    ?>
                                    <option <?php echo $is_selected; ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                    <?php
                                endforeach;
                                ?>
                            </select>
                            <span class="input-group-btn">
                                <button type="button" onclick="" class="btn btn-default btn-sm"><i class="fa fa-map-marker"></i></button>
                            </span>
                        <?php else: ?>
                            <input type="text" name="" value="No Set Locations" class="form-control" disabled required>
                            <span class="input-group-btn">
                                <button type="button" name="button" class="btn btn-default btn-sm" href="<?php echo Yii::app()->request->baseUrl; ?>/account/setup#listing"><i class="fa fa-gear"></i> Setup</button>
                            </span>
                        <?php endif; ?>
                    </div>
				</div>
			</div>
            
        </div>
    </div>

    <div class="col-xs-offset-3">
        <p class="page-note"></p>
    </div>

    <!-- footer buttons -->
    <div class="col-xs-12">
        <div class="col-xs-offset-2 col-xs-2">
            <button type="button" name="button" class="btn btn-primary btn-block  btn-action-item">Action Item</button>
        </div>
        <div class="col-xs-2">
            <button type="button" name="button" class="btn btn-primary btn-block  btn-add-note">Add Note</button>
        </div>
        <div class="col-xs-2">
            <button type="button" name="button" class="btn btn-warning btn-block " href="<?php echo Yii::app()->request->baseUrl; ?>/agentprep/step_current_coverages">Previous</button>
        </div>
        <div class="col-xs-2">
            <button type="submit" name="button" class="btn btn-warning btn-block ">Next</button>
        </div>
        <?php echo CHtml::endForm(); ?>

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