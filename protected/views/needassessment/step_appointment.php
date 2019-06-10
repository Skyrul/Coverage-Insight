<?php
$this->with_progressbar = true;
$this->goto_menu = false;
$this->progress_bar = array('start' => '100', 'end' => '0');
$this->page_label = $customer->primary_firstname . ' ' . $customer->primary_lastname . '' .
        (($customer->secondary_firstname) ? ' & ' . $customer->secondary_firstname . ' ' . $customer->secondary_lastname : '');
?>
<style>
    .title  {
        width: 200px;
        font-size: 1.2em;
        font-weight: bold;
        text-align: left;
        padding: 2px;
    }
    .form-control {
        border: 1px solid white;
        width: 380px !important;
        margin-left: 6px;
        background-color: white;
        margin-bottom: 8px !important;
    }
    .form-control:disabled {
        background-color: white;
    }
    .btn {
        margin-bottom: 8px !important;
    }
    .select2-container--default {
        width: 200px !important;
        margin-left: 6px;
        margin-bottom: 8px !important;
        border: 1px solid gray;
    }
    .input-group-btn {
        display:none;
    }
</style>

<div class="col-xs-12">
    <div class="row">
        <div class="page-sub-label text-center">Appointment</div>
    </div>

    <p>&nbsp;</p>

    <?php if($model != null): ?>
    <?php echo CHtml::beginForm(); ?>
        <div class="row">
            <div class="col-xs-offset-4 col-xs-8">
                <table>
                    <tr>
                        <td><span class="title">Date:</span></td>
                        <td>
                            <div class="input-group">
                                <?php echo CHtml::textField('Appointment[appointment_date]', CHtml::encode(date('l, F jS, Y', strtotime($model->appointment_date))), array('disabled'=>true)); ?>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="title">Time:</span></td>
                        <td>
                            <div class="input-group">
                                <input name="Appointment[appointment_time]" type="text" class="form-control" value="<?php echo $model->appointment_time; ?>" disabled>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-clock-o"></i></button>
                                </span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="title">Location:</span></td>
                        <td>
                            <div class="input-group">
                                <input type="text" class="form-control" value="<?php echo date('m/d/Y', strtotime($model->appointment_date)); ?>" disabled="true">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-sm" disabled=""><i class="fa fa-map-marker"></i></button>
                                </span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="title">Note:</span></td>
                        <td>
                            <div class="input-group">
                                <input type="text" class="form-control" value="We look forward to meeting with you!" disabled="true">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-sm" disabled=""><i class="fa fa-map-marker"></i></button>
                                </span>
                            </div>
                        </td>
                    </tr>
                </table>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <p class="text-center">No appoinment set</p>
        </div>
    <?php endif; ?>

    <!-- footer buttons -->
    <div class="col-xs-12" style="padding-bottom:2em; margin-bottom:2em;">
        <div class="col-xs-offset-2 col-xs-2">
        </div>
        <div class="col-xs-2">
            <?php
            echo CHtml::button('Previous', array(
                'submit' => '?direction=prev', 'class' => 'btn btn-primary btn-block',
            ));
            ?>
        </div>
        <div class="col-xs-2">
            <?php
            echo CHtml::button('Close', array(
                'submit' => '?direction=next', 'class' => 'btn btn-warning btn-block',
            ));
            ?>
        </div>
        <div class="col-xs-2">
        </div>
    </div>
    <?php echo CHtml::endForm(); ?>

    <script>
    <?php 
    if (Yii::app()->session['arr_pages']){ 
    echo 'global_config.page_names = ' . json_encode(Yii::app()->session['arr_pages']) . ';'; 
    }
    ?>
    </script>

    <script>
        global_config.page_name = "<?php echo basename(__FILE__, '.php'); ?>";
    </script>

    <?php
    // custom script
    Yii::app()->clientScript->registerScriptFile(
            Yii::app()->baseUrl . '/js/pages/need_assessment.js', CClientScript::POS_END
    );
    ?>
