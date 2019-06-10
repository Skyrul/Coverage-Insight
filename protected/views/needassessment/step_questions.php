<?php
// echo $line_question['title'];
$this->with_progressbar = true;
$this->progress_bar = array('start'=>'60', 'end'=>'40');
$this->page_label = $customer->primary_firstname.' '.$customer->primary_lastname.''.
    (($customer->secondary_firstname) ? ' & '.$customer->secondary_firstname.' '.$customer->secondary_lastname : '');

?>
<style>
.form-control {
  width: 34em;
  margin-bottom: 10px;
}

ul {
    list-style: none;
    margin-left: 40px;
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

<div class="container">
  <div class="col-xs-12">
    <div class="page-sub-label text-center">Question</div>
    <p>&nbsp;</p>
  </div>
  <?php
      $form=$this->beginWidget('CActiveForm', array(
        'id'=>'new-form',
        'enableAjaxValidation' => true,
        'htmlOptions'=> array('class'=>'form-horizontal'),
      ));
  ?>
  <div class="col-xs-12">
    <div class="col-xs-offset-2 col-xs-8">
      <?php
        echo CHtml::errorSummary($model);
       ?>
    </div>
  </div>

  <div class="col-xs-12">
    <div class="col-xs-offset-2 col-xs-8">
      <table>
        <tr>
            <td>
                <h4>
                    <?php echo $line_question['policy_questions']; ?><br><br>
                </h4>
            </td>
        </tr>
        <tr>
            <td>
                <ul>
                    <?php 
                    $cri = new CDbCriteria;
                    $cri->condition="account_id = :account_id AND customer_id = :customer_id AND policy_parent_label = :policy_parent_label";
                    $cri->params = array(
                        ':account_id'=>Yii::app()->session['account_id'],
                        ':customer_id'=>Yii::app()->session['customer_id'],
                        ':policy_parent_label'=>$line_question['title'],
                    );
                    $option_s = '';
                    $pl = PolicyLineQuestion::model()->find($cri);
                    if ($pl!=null) {
                        $option_s = $pl->policy_child_selected;
                    } 
                    $selections = array('Yes', 'No', 'Not Sure');
                    foreach($selections as $skey=>$sval):
                        $is_checked = ($option_s==$sval) ? 'checked' : '';
                    ?>
                        <li><input <?php echo $is_checked; ?> type="checkbox" name="Question[option]" value="<?php echo $sval; ?>" id="opt<?php echo $skey; ?>"><label for="opt<?php echo $skey; ?>"><?php echo $sval; ?></label></li>
                    <?php
                    endforeach;
                    ?>
                </ul>
            </td>
        </tr>
      </table>
    </div>
  </div>

  <!-- footer buttons -->
  <div class="col-xs-12" style="margin-bottom:1em;">
    <div class="col-xs-offset-2 col-xs-2">
    </div>
    <div class="col-xs-2">
      <?php
        echo CHtml::button('Previous', array(
            'submit'=>'?qid='. $line_question['id'] .'&direction=prev', 'class'=>'btn btn-primary btn-block',
        ));
      ?>
    </div>
    <div class="col-xs-2">
      <button type="button" name="button" class="btn btn-primary btn-block" href="<?php echo Yii::app()->session['skip_url']; ?>">Skip</button>
    </div>
    <div class="col-xs-2">
      <?php
        echo CHtml::button('Next', array(
            'submit'=>'?qid='. $line_question['id'] .'&direction=next', 'class'=>'btn btn-warning btn-block',
        ));
      ?>
    </div>
  </div>
  <?php $this->endWidget(); ?>
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
