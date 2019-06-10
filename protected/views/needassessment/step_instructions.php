<?php
$this->with_progressbar = true;
$this->progress_bar = array('start'=>'0', 'end'=>'100');
$this->page_label = $customer->primary_firstname.' '.$customer->primary_lastname.''.
                    (($customer->secondary_firstname) ? ' & '.$customer->secondary_firstname.' '.$customer->secondary_lastname : '');
?>
<style>
  .form-control {
    width: 34em;
    margin-bottom: 5px;
  }
  h4 {
      font-size: 1.4em;
  }
</style>

<div class="container">
  <div class="col-xs-12">
    <div class="page-sub-label text-center">Welcome</div>
    <p>&nbsp;</p>
  </div>
  <div class="col-xs-12">
    <div class="col-xs-offset-2 col-xs-8">
    </div>
  </div>

  <div class="col-xs-12">
    <div class="col-xs-offset-2 col-xs-8">
      <h4>
        Thank you for taking time to complete this brief Needs Assessment.<br>
        Completing this questionnaire will help ensure that we spend time discussing the <br>
        items that are most important to you.<br><br>

        The questionnaire should take less than 5 minutes to complete. If you do not feel<br>
        comfortable answering any question, you are welcome to skip it using the skip<br>
        button. If you need to quit and come back you may do so at any time, simply press<br>
        the Save & Exit button at the bottom of the page.<br><br>
        
        Use the Next and Previous buttons to navigate the questionnaire. Press Next below<br>
        when you are ready to begin.
      </h4>
    </div>
  </div>

  <!-- footer buttons -->
  <div class="col-xs-12" style="margin-top: 2em;margin-bottom:1em;">
    <div class="col-xs-offset-2 col-xs-2">
    </div>
    <div class="col-xs-2">
<!--      <button type="button" name="button" class="btn btn-primary btn-block" href="<?php echo Yii::app()->request->baseUrl; ?>/<?php echo $this->id; ?>/step_dependents">Previous</button>-->
    </div>
    <div class="col-xs-2">
      <button type="button" name="button" class="btn btn-primary btn-block" href="<?php echo Yii::app()->request->baseUrl; ?>/<?php echo $this->id; ?>/step_customer1">Skip</button>
    </div>
    <div class="col-xs-2">
      <button type="button" name="button" class="btn btn-warning btn-block" href="<?php echo Yii::app()->request->baseUrl; ?>/<?php echo $this->id; ?>/step_customer1">Next</button>
    </div>
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
global_config.page_name="<?php echo basename(__FILE__, '.php'); ?>";
</script>

<?php
// custom script
Yii::app()->clientScript->registerScriptFile(
	Yii::app()->baseUrl . '/js/pages/need_assessment.js',
	CClientScript::POS_END
);
?>
