<style>
  .form-control {
    width: 34em;
    margin-bottom: 5px;
  }
</style>

<div class="container">
  <div class="col-xs-12">
      <h3 class="text-center">Customer Insurance Review Complete</h3>
      <hr>
  </div>
  <p>&nbsp;</p>
  <div class="col-xs-12">
    <div class="col-xs-offset-2 col-xs-8">
        <img src="<?php echo $this->applicationLogo(EnumLogo::CLIENT); ?>" style="width:84%;display:block;margin:0 auto;">
    </div>
  </div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  
  <!-- footer buttons -->
  <div class="col-xs-12" style="margin-bottom:1em;">
    <div class="col-xs-2">
    </div>
    <div class="col-xs-2">
    </div>
    <div class="col-xs-2">
    </div>
    <div class="col-xs-2">
      <?php
        echo CHtml::button('Back', array(
            'submit'=>'?customer_id='. $customer->id .'&direction=prev',
            'class'=>'btn btn-primary btn-block',
        ));
      ?>
    </div>
    <div class="col-xs-2">
      <?php
        echo CHtml::button('Next', array(
            'submit'=>'?customer_id='. $customer->id .'&direction=next',
            'class'=>'btn btn-warning btn-block',
        ));
      ?>
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
<?php $this->loadActivity(); ?>
</script>

<?php
// custom script
Yii::app()->clientScript->registerScriptFile(
	Yii::app()->baseUrl . '/js/pages/need_assessment.js',
	CClientScript::POS_END
);
?>
