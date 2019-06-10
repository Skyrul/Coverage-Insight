<?php
$this->with_progressbar = true;
$this->progress_bar = array('start'=>'70', 'end'=>'30');
$this->page_label = $customer->primary_firstname.' '.$customer->primary_lastname.''.
                    (($customer->secondary_firstname) ? ' & '.$customer->secondary_firstname.' '.$customer->secondary_lastname : '');

$cri = new CDbCriteria;

$cri->condition="account_id=:account_id AND customer_id=:customer_id";
$cri->params=array(
        ':account_id'=>Yii::app()->session['account_id'],
        ':customer_id'=>Yii::app()->session['customer_id'],
);
$action_items = ActionItem::model()->findAll($cri);
$maincontent = '';
$maincontent .= '<table class="col-xs-12">';
if(!empty($action_items)) {
    foreach($action_items as $k=>$act) {
        $maincontent .= '<tr><td>&nbsp;</td></tr>';
        $maincontent .= '<tr>';
        $maincontent .= '<td>';
        $maincontent .= '<span class="box col-xs-5">'. $act->action_type_code .'</span>';
        $maincontent .= '<span class="box col-xs-6">'. $act->description .'</span>';
        $maincontent .= '</td>';
        $maincontent .= '</tr>';
    }
}
$maincontent .= '</table>';

?>
<style>
    .form-control {
      margin-bottom: 10px;
    }
    
    .box {
        border: 1px solid lightgray;
        padding: 8px;
        margin-right: 10px;
        font-size: 16px;
        color: orange;
        height: 40px;
    }
    
    .box:hover {
        background-color: lightgray;
    }
</style>

<?php
    $form=$this->beginWidget('CActiveForm', array(
      'id'=>'new-form',
      'enableAjaxValidation' => true,
      'htmlOptions'=> array('class'=>'form-horizontal'),
    ));
?>
<div class="container">
  <div class="col-xs-12">
    <div class="page-sub-label text-center">Action Items</div>
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
        <button type="button" name="button" class="btn btn-primary btn-block btn-action-item">Add Action Item</button>
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
