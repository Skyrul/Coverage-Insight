<?php
$this->with_progressbar = true;
$this->progress_bar = array('start'=>'60', 'end'=>'40');
$this->page_label = $customer->primary_firstname.' '.$customer->primary_lastname.''.
                    (($customer->secondary_firstname) ? ' & '.$customer->secondary_firstname.' '.$customer->secondary_lastname : '');

// $selections = array(
//     'Retirement Planning',
//     'Protecting Vehicles',
//     'Savings',
//     'Critical Illness',
//     'Protecting Your Home',
//     'Long-Term Care',
//     'Reducing Debt',
//     'Income Protection',
//     'Life Insurance',
//     'Asset Protection',    
// );
$ctr=0;
$maincontent = '';
$scri=New CDbCriteria;

$selections = TopConcernsOptions::model()->findAll();
foreach($selections as $skey=>$sval):
  $insurance_checked = AccountSetup::model()->find('id=:account_id AND is_'. $sval->insurance_type.'_checked = 1', array(
      ':account_id'=>Yii::app()->session['account_id'],
  ));
  if ($insurance_checked != null):
    $ctr++;
    if ($ctr == 1) {
        $maincontent .='<tr>';
    }
    $scri->condition="account_id=:account_id AND customer_id=:customer_id AND concern_question = :concern_question";
    $scri->params=array(
        ':account_id'=>Yii::app()->session['account_id'],
        ':customer_id'=>Yii::app()->session['customer_id'],
        ':concern_question'=>$sval->option_text,
    );  
    $is_checked='';
    if (TopConcerns::model()->find($scri)!=null) {
      $is_checked = 'checked';  
    }
    $maincontent .='<td><input '.$is_checked.' type="checkbox" name="TopConcerns[option]['.$skey.']" id="opt'.$skey.'" value="'. $sval->option_text .'"><label for="opt'. $skey .'">'. $sval->option_text .'</label></td>';
    if ($ctr == 2) {
        $ctr=0;
        $maincontent .='</tr>';
    }
  endif;
endforeach;
?>
<style>
    .form-control {
      width: 14em;
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
    <div class="page-sub-label text-center">Top Concerns</div>
    <p>&nbsp;</p>
  </div>

  <div class="col-xs-12">
    <div class="col-xs-offset-2 col-xs-8">
      <table>
        <tr>
            <td colspan="10">
                <h4>
                    Please mark your top 3 concerns from the list below?
                </h4>
            </td>
        </tr>
        <tr><td colspan="10"><p>&nbsp;</p></td></tr>
        <?php echo $maincontent; ?>
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
      <button type="button" name="button" class="btn btn-primary btn-block" href="<?php echo Yii::app()->request->baseUrl; ?>/<?php echo $this->id; ?>/step_life_changes">Skip</button>
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
