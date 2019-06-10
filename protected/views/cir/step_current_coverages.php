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

$maincontent = '';
$maincontent2 ='';

if (!empty($policies)) 
{
    $maincontent .= '<table>';
    foreach($policies as $key=>$value) {
        $criteria->condition = "account_id=:account_id AND customer_id=:customer_id AND policy_parent_code = :policy_parent_code AND policy_child_label = :policy_child_label";
        $criteria->params=array(
            ':account_id'=>Yii::app()->session['account_id'],
            ':customer_id'=>Yii::app()->session['customer_id'],
            ':policy_parent_code'=>$line_insurance['title'],
            ':policy_child_label'=>$value->policy_child_label,
        );  
        $cur_cov = CurrentCoverage::model()->findAll($criteria);
        if (!empty($cur_cov)) {
            foreach($cur_cov as $k1=>$v1) 
            {
                $d = true;
                if ($line_insurance['title'] == 'Home' && $value->policy_child_label == 'Type') {
                    $d = false;
                }
                if ($line_insurance['title'] == 'Auto' && ($value->policy_child_label == 'Year' || $value->policy_child_label == 'Make' || $value->policy_child_label == 'Model')) {
                    $d = false;
                }
                
                if ($k1 == 0) {
                    if ($d) {
                        $maincontent .= '<tr>';
                        $maincontent .= '<td><label>'. $value->policy_child_label .'</label></td>';
                        $fld_value = ($v1->cir_answer == '' || $v1->cir_answer == null) ? $v1->policy_child_selected : $v1->cir_answer;
                        $maincontent .= '<td><input data-id="'. $value->id .'" type="text" name="CurrentCoverage[policy_child_label]['. $value->policy_parent_label .']['.$value->policy_child_label.']" value="'. $fld_value .'"></td>';
                        $maincontent .= '</tr>';
                    }
                }
            }
        }
    }
    $maincontent .= '</table>';
}

if ($maincontent == '<table></table>') {
    $maincontent = '<h4 style="text-align: center;background-color:orange;color:white;">No records for '. str_replace('_', ' ', $line_insurance['title']) .'</h4><br><br>';
}


$crp = new CDbCriteria;
$crp->condition = "account_id=:account_id AND customer_id=:customer_id AND policy_parent_label = :policy_parent_label";
$crp->params=array(
    ':account_id'=>Yii::app()->session['account_id'],
    ':customer_id'=>Yii::app()->session['customer_id'],
    ':policy_parent_label'=>$line_insurance['title'],
);  
$policy_line_insurance = PolicyLineQuestion::model()->find($crp);
$policy_line_insurance_text = '';
if ($policy_line_insurance != null) {
    $policy_line_insurance_text = ($policy_line_insurance->cir_answer == '') ? $policy_line_insurance->policy_child_selected : $policy_line_insurance->cir_answer;
}


$crp->condition = "account_id=:account_id AND customer_id=:customer_id";
$crp->params=array(
    ':account_id'=>Yii::app()->session['account_id'],
    ':customer_id'=>Yii::app()->session['customer_id'],
); 
$life_changes = LifeChanges::model()->findAll($crp);
$life_changes_text = '';
foreach($life_changes as $k=>$v) {
    if ($v->cir_answer == '' || $v->cir_answer == null) {
        $life_changes_text .= $v->life_answer. ", ";
    } else {
        $life_changes_text = $v->cir_answer;
    }
}
$top_concerns = TopConcerns::model()->findAll($crp);
$top_concerns_text = '';
foreach($top_concerns as $k=>$v) {
    if ($v->cir_answer == '' || $v->cir_answer == null) {
        $top_concerns_text .= $v->concern_answer . ", ";
    } else {
        $top_concerns_text = $v->cir_answer;
    }
}

$maincontent2 .= '<table>';
$maincontent2 .= '<tr valign="top">';
$maincontent2 .= '<td><label style="width:80%;font-size: 14px;">'. $line_insurance['policy_questions'] .'</label></td>';
$maincontent2 .= '<td><input style="border:1px solid white;" type="text" name="NA[LineQuestion]['. $line_insurance['title'] .']" value="'. $policy_line_insurance_text .'" readonly="true"></td>';
$maincontent2 .= '</tr>';
$maincontent2 .= '<tr>';
$maincontent2 .= '<td><label>Life Changes</label></td>';
$maincontent2 .= '<td><input style="border:1px solid white;" type="text" name="NA[LifeChanges]" value="'. $life_changes_text .'" readonly="true"></td>';
$maincontent2 .= '</tr>';
$maincontent2 .= '<tr>';
$maincontent2 .= '<td><label>Top Concerns</label></td>';
$maincontent2 .= '<td><input style="border:1px solid white;" type="text" name="NA[TopConcerns]" value="'. $top_concerns_text .'" readonly="true"></td>';
$maincontent2 .= '</tr>';
$maincontent2 .= '</table>';

$crp->condition = "account_id=:account_id AND customer_id=:customer_id AND page_url LIKE '%current_coverage%' AND dom_element LIKE :dom_element";
$crp->params=array(
    ':account_id'=>Yii::app()->session['account_id'],
    ':customer_id'=>Yii::app()->session['customer_id'],
    ':dom_element'=>'%'. $line_insurance['title'] . '%'
);
$note = Note::model()->find($crp);
$note_text = ($note!=null) ? '<strong>Note:</strong><br>'.$note->msg_note : '';
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
    <div class="page-sub-label text-center">Current Coverages - <?php echo str_replace('_', ' ', $line_insurance['title']); ?></div>
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
        <?php echo $maincontent; ?>
    </div>
  </div>
 
  <div class="row" style="border-bottom: 2px solid lightgray;">
      <p>&nbsp;</p>
  </div>
  
  <div class="col-xs-12">
    <div class="page-sub-label text-center">Needs Assessment</div>
    <p>&nbsp;</p>
  </div>
    
  <div class="col-xs-12">
    <div class="col-xs-offset-2 col-xs-10">
        <?php echo $maincontent2; ?>
    </div>
  </div>

  <div class="col-xs-12">
      <div class="col-xs-offset-2 col-xs-8">
          <p style="color: red;"><?php echo $note_text; ?></p>
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
