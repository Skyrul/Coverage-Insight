<?php
$this->with_progressbar = false;
$this->progress_bar = array('start' => '80', 'end' => '20');
//$this->page_label = $customer->primary_firstname . ' ' . $customer->primary_lastname . '' .
//        (($customer->secondary_firstname) ? ' & ' . $customer->secondary_firstname . ' ' . $customer->secondary_lastname : '');

$this->with_footer_menu = 'hide';
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
            <h1 class="text-center">Thank You!</h1>
            <h4 class="text-center">Thank you for your time completing this Needs Assessment. We will review your information and contact you shortly, so please watch your inbox.</h4>
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
