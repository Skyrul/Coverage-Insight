<?php
$this->with_progressbar = true;
$this->progress_bar = array('start'=>'80', 'end'=>'20');
$this->page_label = $customer->primary_firstname.' '.$customer->primary_lastname.''.
                    (($customer->secondary_firstname) ? ' & '.$customer->secondary_firstname.' '.$customer->secondary_lastname : '');

$cri = new CDbCriteria;
$cri->condition="account_id=:account_id AND customer_id=:customer_id";
$cri->params=array(
        ':account_id'=>Yii::app()->session['account_id'],
        ':customer_id'=>Yii::app()->session['customer_id'],
);  
$record = LongTermGoals::model()->find($cri);
$text1='';
$text2='';
if ($record!=null) {
    $text1 = $record->first_goal;
    $text2 = $record->second_goal;
}


?>
<style>
    .form-control {
      margin-bottom: 10px;
    }

    .step {
        width: 120px;
        font-size: 14px;
        text-align: center;
    }
  
    .select2.select2-container.select2-container--default.select2-container--below {
        width: 100% !important;
        border: 1px solid;
    }
    
    .btn-remove {
      margin-bottom: 12px;
      margin-left: 8px;
    }
    
    input[type="checkbox"] {
        width: 28px;
        height: 28px;
        vertical-align:middle; 
    }

    label {
        font-size: 14px;
        margin-left: 8px;
        vertical-align:middle; 
    }
    
    textarea {
        font-size: 16px;
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
    <div class="page-sub-label text-center">Long Term Goals</div>
    <p>&nbsp;</p>
  </div>

  <div class="col-xs-12">
    <div class="col-xs-offset-2 col-xs-8">
      <table>
        <tr>
            <td colspan="10">
                <h4>
                    Please note any long term goals that you would like to discuss or start planning for:
                </h4>
            </td>
        </tr>
        <tr>
            <td colspan="10">
                <textarea rows="5" cols="70" placeholder="Example: Want to buy a house within the next 2 years" name="LongTermGoals[option][1]" class="form-control"><?php echo $text1; ?></textarea>
            </td>
        </tr>
        <tr><td colspan="10"><p>&nbsp;</p></td></tr>
        <tr>
            <td colspan="10">
                <h4>
                    Please note any other items that you would like to discuss during the meeting
                </h4>
            </td>
        </tr>
        <tr>
            <td colspan="10">
                <textarea rows="5" cols="70" placeholder="Any more notes here" name="LongTermGoals[option][2]" class="form-control"><?php echo $text2; ?></textarea>
            </td>
        </tr>
      </table>
      <p>&nbsp;</p>
    </div>
  </div>

  <!-- footer buttons -->
  <div class="col-xs-12" style="margin-bottom:1em;">
    <div class="col-xs-offset-2 col-xs-2">
    </div>
    <div class="col-xs-2">
      <?php
        echo CHtml::button('Previous', array(
            'submit'=>'?direction=prev', 'class'=>'btn btn-primary btn-block',
        ));
      ?>
    </div>
    <div class="col-xs-2">
      <button type="button" name="button" class="btn btn-primary btn-block" href="<?php echo Yii::app()->request->baseUrl; ?>/<?php echo $this->id; ?>/step_appointment">Skip</button>
    </div>
    <div class="col-xs-2">
      <?php
        echo CHtml::button('Next', array(
            'submit'=>'?direction=next', 'class'=>'btn btn-warning btn-block',
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
</script>

<?php
// custom script
Yii::app()->clientScript->registerScriptFile(
	Yii::app()->baseUrl . '/js/pages/need_assessment.js',
	CClientScript::POS_END
);
?>
