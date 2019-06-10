<?php
$this->with_progressbar = true;
$this->progress_bar = array('start'=>'50', 'end'=>'50');
$this->page_label = $customer->primary_firstname.' '.$customer->primary_lastname.''.
                    (($customer->secondary_firstname) ? ' & '.$customer->secondary_firstname.' '.$customer->secondary_lastname : '');

$criteria = new CDbCriteria;

// Account policies
$criteria->condition = "account_id=:account_id AND policy_parent_label = :policy_parent_label AND is_child_checked = 1";
$criteria->params=array(
    ':account_id'=>Yii::app()->session['account_id'],
    ':policy_parent_label'=>$line_insurance['title'],
);
$policies = AccountSetupPolicy::model()->findAll($criteria);

$maincontent ='';
$maincontent2 ='';


$crp = new CDbCriteria;
$crp->condition = "account_id=:account_id AND customer_id=:customer_id";
$crp->params=array(
    ':account_id'=>Yii::app()->session['account_id'],
    ':customer_id'=>Yii::app()->session['customer_id'],
); 
$top_concerns = TopConcerns::model()->findAll($crp);

$crp->condition = "account_id=:account_id AND customer_id=:customer_id AND action_type = 'Concern'";
$crp->params=array(
    ':account_id'=>Yii::app()->session['account_id'],
    ':customer_id'=>Yii::app()->session['customer_id'],
); 
$goals_concern = GoalsConcern::model()->findAll($crp);


// Concerns Section
$maincontent .= '<table>';
foreach($top_concerns as $k=>$v) {
    $maincontent .= '<tr>';
    $is_checked = ($v->cir_answer =='' || $v->cir_answer =='off') ? '' : 'checked';
    $maincontent .= '<td><input '. $is_checked .' name="TopConcern[Option][cir_answer]['. $v->id .']" type="checkbox"></td>';
    $maincontent .= '<td><label>'. $v->concern_answer .'</label></td>';
    $maincontent .= '</tr>';   
}
foreach($goals_concern as $k=>$v) {
    $maincontent .= '<tr>';
    $is_checked = ($v->cir_answer =='' || $v->cir_answer =='off') ? '' : 'checked';
    $maincontent .= '<td><input '. $is_checked .' name="GoalConcern[Option][cir_answer]['. $v->id .']" type="checkbox"></td>';
    $maincontent .= '<td><label>'. $v->action_description .'</label></td>';
    $maincontent .= '</tr>';   
}
$maincontent .= '</table>';


// Questions
$crp->condition = "account_id=:account_id AND customer_id=:customer_id";
$crp->params=array(
    ':account_id'=>Yii::app()->session['account_id'],
    ':customer_id'=>Yii::app()->session['customer_id'],
);
$long_term_goals = LongTermGoals::model()->find($crp);

$maincontent2 .= '<table>';
if($long_term_goals != null) {
    $maincontent2 .= '<tr valign="top">';
    $is_checked = ($long_term_goals->cir_answer =='' || $long_term_goals->cir_answer =='off') ? '' : 'checked';
    $maincontent2 .= '<td><input '. $is_checked .' name="Question['. $long_term_goals->id .']" type="checkbox"></td>';
    $maincontent2 .= '<td><label>'. $long_term_goals->second_goal .'</label></td>';
    $maincontent2 .= '</tr>';
}
$maincontent2 .= '</table>';
$maincontent2 .= '<p>&nbsp;</p>';

$crp->condition = "account_id=:account_id AND customer_id=:customer_id AND page_url LIKE '%current_coverage%' AND dom_element LIKE :dom_element";
$crp->params=array(
    ':account_id'=>Yii::app()->session['account_id'],
    ':customer_id'=>Yii::app()->session['customer_id'],
    ':dom_element'=>'%'. $line_insurance['title'] . '%'
);
$note = Note::model()->find($crp);
$note_text = ($note!=null) ? 'Note:<br>'.$note->msg_note : '';
?>
<style>
.form-control {
  width: 34em;
  margin-bottom: 10px;
}

ul {
    list-style: none;
    margin-left: 160px;
    margin-top: 20px;
    margin-bottom: 20px;
}

input[type="checkbox"] {
    width: 28px;
    height: 28px;
    vertical-align:middle; 
}

label {
    font-size: 18px;
    margin-left: 8px;
    vertical-align:middle; 
}
</style>

<div class="container">
  <div class="col-xs-12">
    <div class="page-sub-label text-center">Concerns & Questions</div>
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
    <div class="page-sub-label text-left">Concerns</div>
    <hr>
  </div>
  <div class="col-xs-12">
    <div class="col-xs-offset-2 col-xs-8">
        <?php echo $maincontent; ?>
    </div>
  </div>
   
  <div class="col-xs-12">
      <p>&nbsp;</p>
    <div class="page-sub-label text-left">Questions</div>
    <hr>
  </div>    
  <div class="col-xs-12">
    <div class="col-xs-offset-2 col-xs-10">
        <?php echo $maincontent2; ?>
    </div>
  </div>

  <div class="col-xs-12">
      <div class="col-xs-offset-2 col-xs-8">
          <p class="page-note"><?php echo $note_text; ?></p>
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
            'submit'=>'?customer_id='. $customer->id .'&direction=prev&qid='. $line_insurance['id'],
            'class'=>'btn btn-primary btn-block',
        ));
      ?>
    </div>
    <div class="col-xs-2">
      <?php
        echo CHtml::button('Next', array(
            'submit'=>'?customer_id='. $customer->id .'&direction=next&qid='. $line_insurance['id'],
            'class'=>'btn btn-warning btn-block',
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
<?php $this->loadActivity(); ?>
</script>

<?php
// custom script
Yii::app()->clientScript->registerScriptFile(
	Yii::app()->baseUrl . '/js/pages/cir.js',
	CClientScript::POS_END
);
?>
