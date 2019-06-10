<?php
$this->with_progressbar = true;
$this->progress_bar = array('start'=>'60', 'end'=>'40');
$this->page_label = $customer->primary_firstname.' '.$customer->primary_lastname.''.
                    (($customer->secondary_firstname) ? ' & '.$customer->secondary_firstname.' '.$customer->secondary_lastname : '');

$cri = new CDbCriteria;

// Customer Review
$cri->condition="account_id=:account_id AND customer_id=:customer_id AND action_type = 'Goal'";
$cri->params=array(
        ':account_id'=>Yii::app()->session['account_id'],
        ':customer_id'=>Yii::app()->session['customer_id'],
);  
$goals = GoalsConcern::model()->findAll($cri);
$maincontent = '';
if (!empty($goals)) {
    $maincontent .= '<table class="col-xs-12">';
    foreach($goals as $k=>$v) {
        $maincontent .= '<tr>';
        $maincontent .= '<td class="col-xs-10"><textarea class="form-control" rows="1" cols="100">'. $v->action_description .'</textarea></td>';
        $maincontent .= '</tr>';
    }
    $maincontent .= '</table>';
}

// Needs Assessment
$cri->condition="account_id=:account_id AND customer_id=:customer_id";
$cri->params=array(
        ':account_id'=>Yii::app()->session['account_id'],
        ':customer_id'=>Yii::app()->session['customer_id'],
);
$ltg = LongTermGoals::model()->find($cri);
$maincontent2 = '';
if($ltg != null) {
    $maincontent2 .= '<table class="col-xs-12">';
    $maincontent2 .= '<tr>';
    $maincontent2 .= '<td class="col-xs-10"><textarea class="form-control" rows="2" cols="100">'. $ltg->first_goal .'</textarea></td>';
    $maincontent2 .= '</tr>';
    $maincontent2 .= '</table>';
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
    <div class="col-xs-12">
      <div class="page-sub-label text-left">Customer Insurance Review</div>
      <p>&nbsp;</p>
      <hr>
    </div>
    <div class="col-xs-12">
      <table>
        <?php 
        if ($maincontent != '') {
            echo $maincontent;
        }
        ?>
      </table>
      <p>&nbsp;</p>
    </div>
  </div>
    
  <div class="col-xs-12">
    <div class="col-xs-12">
      <div class="page-sub-label text-left">Needs Assessment</div>
      <p>&nbsp;</p>
      <hr>
    </div>
    <div class="col-xs-12">
      <table>
        <?php 
        if ($maincontent2 != '') {
            echo $maincontent2;
        }
        ?>
      </table>
      <p>&nbsp;</p>
    </div>
  </div>

  <!-- footer buttons -->
  <div class="col-xs-12" style="margin-bottom:1em;">
    <div class="col-xs-2">
    </div>
    <div class="col-xs-2">
      <button type="button" name="button" class="btn btn-primary btn-block btn-action-item">Action Item</button>
    </div>
    <div class="col-xs-2">
      <button type="button" name="button" class="btn btn-primary btn-block btn-goals-concerns">Goals & Concerns</button>
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
