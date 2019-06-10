<?php
$this->with_progressbar = false;
$this->progress_bar = array('start' => '80', 'end' => '20');
//$this->page_label = $customer->primary_firstname . ' ' . $customer->primary_lastname . '' .
//        (($customer->secondary_firstname) ? ' & ' . $customer->secondary_firstname . ' ' . $customer->secondary_lastname : '');
?>

<style>
h4.text-center {
    line-height: 2em;
}
</style>

<div class="col-xs-12">
    <div class="row">
<!--        <div class="page-sub-label text-center">Needs Assessment Completed!</div>-->
    </div>

    <p>&nbsp;</p>

    <div class="row">
        <div class="col-xs-offset-2 col-xs-8">
            <h1 class="text-center">Progress Saved!</h1>
            <h4 class="text-center">We have saved your current Needs Assessment progress for you can go back again later, <br>To return to saved progress Re-access the Needs Assessment Link on your Inbox.</h4>
        </div>
    </div>

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
