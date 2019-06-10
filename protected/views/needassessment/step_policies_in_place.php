<?php
// echo $line_question['title'];
$this->with_progressbar = true;
$this->progress_bar = array('start'=>'50', 'end'=>'50');
$this->page_label = $customer->primary_firstname.' '.$customer->primary_lastname.''.
    (($customer->secondary_firstname) ? ' & '.$customer->secondary_firstname.' '.$customer->secondary_lastname : '');


$criteria = new CDbCriteria;

// Account policies
$criteria->condition = "account_id=:account_id AND policy_parent_label = :policy_parent_label AND is_child_checked = 1";
$criteria->params=array(
    ':account_id'=>Yii::app()->session['account_id'],
    ':policy_parent_label'=>$line_question['title'],
);
$policies = AccountSetupPolicy::model()->findAll($criteria);
$maincontent ='';

if (!empty($policies)) {
    $limit_row_only=0;
    foreach($policies as $key=>$value) {
        $limit_row_only++;
        if ($limit_row_only >= 2) {
            break;
        }
        $maincontent .='<tr>';
        if ($line_question['title'] == 'Auto') {
            $maincontent .='<td class="col-xs-3"><span class="step"><strong>Year</strong></span></td>';
            $maincontent .='<td class="col-xs-3"><span class="step"><strong>Make</strong></span></td>';
            $maincontent .='<td class="col-xs-3"><span class="step"><strong>Model</strong></span></td>';
        } 
        else {
            $maincontent .='<td class="col-xs-3"><span class="step"><strong>'. $value->policy_child_label .'</strong></span></td>';
        }
        $maincontent .='<td class="col-xs-2"><span class="step"><strong>Insurance Company</strong></span></td>';
        $maincontent .='</tr>';

        // Edit form
        $criteria->condition = "account_id=:account_id AND customer_id = :customer_id ";
        $criteria->condition .= "AND policy_parent_label=:parent_label AND policy_child_label=:child_label";
        $criteria->params=array(
            ':account_id'=>Yii::app()->session['account_id'],
            ':customer_id'=>Yii::app()->session['customer_id'],
            ':parent_label'=>$value->policy_parent_label,
            ':child_label'=>$value->policy_child_label
        );
        $savedrec = PoliciesInPlace::model()->findAll($criteria);
        if(!empty($savedrec)) {
            foreach($savedrec as $svkey => $svval) {
                $maincontent .='<tr>';
                $maincontent .='<form id="FormEdit_'. $svval->id .'" method="post">';
                $maincontent .='<input type="hidden" name="PolicyInplaceEdit[Edit][id]" value="'. $svval->id .'">';
                $maincontent .='<input type="hidden" name="PolicyInplaceEdit[Edit][parent_label]" value="'. $svval->policy_parent_label .'">';
                $maincontent .='<input type="hidden" name="PolicyInplaceEdit[Edit][child_label]" value="'. $svval->policy_child_label .'">';
                if ($line_question['title'] == 'Auto') {
                    // Year
                    $maincontent .='<td class="col-xs-3">';
                    $maincontent .='<select name="PolicyInplaceEdit[Edit][selected_year]" class="Lfocus" data-id="'. $svval->id .'">';
                    $maincontent .='<option value="'. $svval->policy_child_selected_year .'">'. $svval->policy_child_selected_year .'</option>';
                    $maincontent .='</select>';
                    $maincontent .='</td>';
                    
                    // Make
                    $maincontent .='<td class="col-xs-3">';
                    $maincontent .='<select name="PolicyInplaceEdit[Edit][selected_make]" class="Lfocus" data-id="'. $svval->id .'">';
                    $maincontent .='<option value="'. $svval->policy_child_selected_make .'">'. $svval->policy_child_selected_make .'</option>';
                    $maincontent .='</select>';
                    $maincontent .='</td>';
                    
                    // Model
                    $maincontent .='<td class="col-xs-3">';
                    $maincontent .='<select name="PolicyInplaceEdit[Edit][selected_model]" class="Lfocus" data-id="'. $svval->id .'">';
                    $maincontent .='<option value="'. $svval->policy_child_selected_model .'">'. $svval->policy_child_selected_model .'</option>';
                    $maincontent .='</select>';
                    $maincontent .='</td>';
                } else {
                    $maincontent .='<td class="col-xs-3">';
                    $maincontent .='<select name="PolicyInplaceEdit[Edit][selected]" class="Lfocus" data-id="'. $svval->id .'">';
                    $selections = explode(',', $value->policy_child_values);
                    foreach($selections as $skey=>$sval) {
                        $is_selected = ($sval == $svval->policy_child_selected) ? 'selected' : '';
                        $maincontent .='<option '.$is_selected.' value="'.$sval.'">'.$sval.'</option>';
                    }
                    $maincontent .='</select>';
                    $maincontent .='</td>';
                }
                $maincontent .='<td class="col-xs-2">';
                $maincontent .='<input type="text" name="PolicyInplaceEdit[Edit][insurance_company]" maxlength="254" class="Lfocus" value="'. $svval->insurance_company .'" data-id="'. $svval->id .'">';
                $maincontent .='</td>';
                $maincontent .='<td>';
                $maincontent .='<button type="button" class="btn btn-default btn-sm btn-remove" href="?action=delete&id='. $svval->id .'"><i class="fa fa-close"></i></button>';
                $maincontent .='</td>';
                $maincontent .='</form>';
                $maincontent .='</tr>';
            }
        }

        // New form
        $maincontent .='<tr id="new-form'. md5($value->policy_child_label) .'" style="display:none;">';
        $maincontent .='<form id="NewForm'. md5($value->policy_child_label) .'" method="post">';
        $maincontent .='<input type="hidden" name="PolicyInplaceNew[Add][parent_label]" value="'. $value->policy_parent_label .'">';
        $maincontent .='<input type="hidden" name="PolicyInplaceNew[Add][child_label]" value="'. $value->policy_child_label .'">';
        
        // Iba yung layout ng form sa Auto policy type
        if ($line_question['title'] == 'Auto') {
            $maincontent .='<td class="col-xs-2">';
            $maincontent .=' <select name="NewForm[Add][Year]" class="Lfocus-Add Policy-'. $value->policy_child_label .'" data-id="'. md5($value->policy_child_label) .'">';
            $maincontent .=' </select>';
            $maincontent .='</td>';
            $maincontent .='<td class="col-xs-2">';
            $maincontent .=' <select name="NewForm[Add][Make]" class="Lfocus-Add Policy-'. $value->policy_child_label .'" data-id="'. md5($value->policy_child_label) .'">';
            $maincontent .=' </select>';
            $maincontent .='</td>';
            $maincontent .='<td class="col-xs-2">';
            $maincontent .=' <select name="NewForm[Add][Model]" class="Lfocus-Add Policy-'. $value->policy_child_label .'" data-id="'. md5($value->policy_child_label) .'">';
            $maincontent .=' </select>';
            $maincontent .='</td>';
            $maincontent .='<td class="col-xs-2">';
            $maincontent .='<input type="text" name="NewForm[Add][insurance_company]" maxlength="254" class="Lfocus-Add" data-id="'. md5($value->policy_child_label) .'">';
            $maincontent .='</td>';
        } else {
            $maincontent .='<td class="col-xs-2">';
            $maincontent .=' <select name="PolicyInplaceNew[Add][selected]" class="Lfocus-Add Policy-'. $value->policy_child_label .'" data-id="'. md5($value->policy_child_label) .'">';
            $selections = explode(',', $value->policy_child_values);
            foreach($selections as $skey=>$sval) {
                //$is_selected = $sval
                $maincontent .='<option value="'.$sval.'">'.$sval.'</option>';
            }
            $maincontent .=' </select>';
            $maincontent .='</td>';
            $maincontent .='<td class="col-xs-2">';
            $maincontent .='<input type="text" name="PolicyInplaceNew[Add][insurance_company]" maxlength="254" class="Lfocus-Add" data-id="'. md5($value->policy_child_label) .'">';
            $maincontent .='</td>';
        }        
        $maincontent .='</form>';
        $maincontent .='</tr>';
        
        // space between
        $maincontent .='<tr><td>&nbsp;</td></tr>';
        
        // buttons
        $maincontent .='<tr>';
        $maincontent .='<td colspan="2"><button data-id="'. md5($value->policy_child_label) .'" type="button" class="btn-add-policy btn btn-warning">Add Policy</button></td>';
        $maincontent .='</tr>';
        
        // space between
        $maincontent .='<tr><td>&nbsp;</td></tr>';
    }
}

// Find if there btn-add-policy button
if (strpos($maincontent, 'btn-add-policy') == false) {
    // space between
    $maincontent .='<tr><td>&nbsp;</td></tr>';
    // buttons
    $maincontent .='<tr>';
    $maincontent .='<td colspan="2"><a href="#!">Theres no policies assign on this Insurance type</a></td>';
    $maincontent .='</tr>';
}

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
</style>

<div class="container">
  <div class="col-xs-12">
    <div class="page-sub-label text-center">Policies in Place</div>
    <p>&nbsp;</p>
  </div>

  <div class="col-xs-12">
    <div class="col-xs-offset-2 col-xs-8">
      <table>
        <tr>
            <td colspan="10">
                <h4>
                    <?php echo $line_question['policies_in_place']; ?>
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
