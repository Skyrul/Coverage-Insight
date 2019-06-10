<?php
$this->with_progressbar = true;
$this->progress_bar = array('start'=>'90', 'end'=>'10');
$this->page_label = $customer->primary_firstname.' '.$customer->primary_lastname.''.
                    (($customer->secondary_firstname) ? ' & '.$customer->secondary_firstname.' '.$customer->secondary_lastname : '');

$cri = new CDbCriteria;

$maincontent = '';
$maincontent .= '<div class="col-xs-12 group"><span class="group-title">'. $customer->primary_firstname .' '. $customer->primary_lastname .'</span></div>';
$maincontent .= '<p>&nbsp;</p>';
$maincontent .= '<div class="col-xs-offset-2 group-content">'
        . '       <div class="col-xs-6">'
        . '       <span class="content-text">'. $customer->primary_email .'</span>'
        . '       </div>'
        . '       <div class="col-xs-4">'
        . '       <input name="Customer[Primary]" type="checkbox" class="pull-right">'
        . '       </div>'
        . '      </div>';
$maincontent .= '<p>&nbsp;</p>';
if ($customer->secondary_email != '' || $customer->secondary_email != null) {
$maincontent .= '<div class="col-xs-12 group"><span class="group-title">'. $customer->secondary_firstname .' '. $customer->secondary_lastname .'</span></div>';
$maincontent .= '<p>&nbsp;</p>';
$maincontent .= '<div class="col-xs-offset-2 group-content">'
        . '       <div class="col-xs-6">'
        . '       <span class="content-text">'. $customer->secondary_email .'</span>'
        . '       </div>'
        . '       <div class="col-xs-4">'
        . '       <input name="Customer[Secondary]" type="checkbox" class="pull-right">'
        . '       </div>'
        . '      </div>';
}
$maincontent .= '<p>&nbsp;</p>';
$maincontent .= '<p>&nbsp;</p>';
$maincontent .= '<br>';
$maincontent .= '<div class="col-xs-offset-2 col-xs-8">';
$maincontent .= '<div class="col-xs-4">';
$maincontent .= '  <button type="button" class="btn btn-warning btn-block" onclick="print_report('. $customer->id .')">Print</button>';
$maincontent .= '</div>';
$maincontent .= '<div class="col-xs-4">';
$maincontent .= CHtml::button('Send', array('submit'=>'?action=send', 'class'=> 'btn btn-warning btn-block')); //'  <button class="btn btn-warning btn-block">Send</button>';
$maincontent .= '</div>';
$maincontent .= '</div>';
$maincontent .= '<p>&nbsp;</p>';
$maincontent .= '<p>&nbsp;</p>';
?>
<style>
    .form-control {
      margin-bottom: 10px;
    }
    .group-title {
        font-weight: bold;
        font-size: 18px;
        padding-bottom: 10px;
    }
    .content-text {
        height: 41px;
        padding-top: 8px;
        font-size: 16px;
        display: block;
    }
    .group {
        padding-top: 10px;
        border-top: 2px solid lightgray;
    }
    .group-content {
        margin-top: 10px;
    }
    input[type="checkbox"] {
        width: 32px;
        height: 32px;
    }
</style>

<?php
    $form=$this->beginWidget('CActiveForm', array(
      'id'=>'action-form',
      'enableAjaxValidation' => true,
      'htmlOptions'=> array('class'=>'form-horizontal'),
    ));
?>
<div class="container">
  <div class="col-xs-12">
    <div class="page-sub-label text-center">Send and Print Customer Insurance Review</div>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
  </div>

  <div class="col-xs-offset-2 col-xs-8">
      <table>
          <?php echo $maincontent; ?>
      </table>
      <p>&nbsp;</p>
  </div>

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
<?php $this->endWidget(); ?>

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
	Yii::app()->baseUrl . '/js/pages/cir.js',
	CClientScript::POS_END
);
?>
