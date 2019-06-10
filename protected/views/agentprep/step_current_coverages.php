<?php
$this->with_progressbar = true;
$this->progress_bar = array('start'=>'60', 'end'=>'40');
$this->page_label = $customer->primary_firstname.' '.$customer->primary_lastname.''.
                    (($customer->secondary_firstname) ? ' & '.$customer->secondary_firstname.' '.$customer->secondary_lastname : '');
// page variable
$column_limit = 10;
$column_ctr = 0;
?>
<style>
.policy-title  {
  width: 160px;
  font-size: 14px;
  font-weight: bold;
  font-style: italic;
  text-align: center;
  padding: 2px;
}
.select2-container--default {
    width: 100% !important;
    margin-left: 6px;
    border: 1px solid black;
}
.btn-delete {
    margin-left: 12px;
    margin-top: -2px;
}
.newrow {
    background-color: lightorange;
}
</style>

<script>
// Local declaration
var tpl_new_record = [];
</script>

<div class="col-xs-12">
  <div class="row">
    <div class="page-sub-label text-center">Current Coverages</div>
  </div>

  <p>&nbsp;</p>
  <?php $criteria = new CDbCriteria; ?>

  <?php
  foreach (AccountSetupFunc::insurance_types() as $insurance_type):
  $criteria->condition = "id = :account_id AND is_". str_replace(' ', '_', $insurance_type) ."_checked = :is_checked";
  $criteria->params=array(
    ':account_id'=> Yii::app()->session['account_id'],
    ':is_checked'=>1
  );
  $insurance_type_checked = AccountSetup::model()->find($criteria);
  if ($insurance_type_checked):
  ?>

    <style>
    #datagrid_holder {
        overflow-x: auto;
        display: block;
        margin-top: 12px;
    }
    </style>
    <div id="datagrid_holder" class="container col-xs-12" >
    
      <!-- Edit Grid -->
      <table id="tbl_<?php echo $insurance_type; ?>" class="col-xs-11">
        <thead>
          <tr>
            <td colspan="10"><span class="step-head"><?php echo $insurance_type; ?></span></td>
          </tr>
          <tr>
            <?php
            // Policy Title
            $criteria->condition = "account_id = :account_id AND policy_parent_label = :insurance_type AND is_child_checked = 1";
            $criteria->params=array(':insurance_type'=>$insurance_type, ':account_id'=> Yii::app()->session['account_id']);
            $criteria->order='id ASC';
            $account_policies = AccountSetupPolicy::model()->findAll($criteria);
            $column_ctr = 0;
            foreach ($account_policies as $key => $value):
              $column_ctr++;
            ?>
               <td><div class="policy-title"><?php echo $value->policy_child_label; ?></div></td>
            <?php
            endforeach;

            // fill=up the remaining column
            for ($i=$column_ctr; $i <= $column_limit; $i++) {
              echo '<td><div class="policy-title">&nbsp;</div></td>';
            }
            // End: Policy Title
            ?>
          </tr>
        </thead>
        <tbody>
            <!-- Edit existing record -->
            <?php
            // Get the "First" and "Last" label
            $edit_cri = new CDbCriteria;
            $edit_cri->condition = "account_id = :account_id AND policy_parent_label = :policy_parent_label AND is_child_checked = 1";
            $edit_cri->params=array(
              ':account_id'=> Yii::app()->session['account_id'],
              ':policy_parent_label'=>$insurance_type,
            );
            $edit_cri->order="id ASC";
            $first_child = AccountSetupPolicy::model()->find($edit_cri);
            $edit_cri->order="id DESC";
            $last_child = AccountSetupPolicy::model()->find($edit_cri);
            
            $edit_cri->condition = "account_id = :account_id "
                    . " AND customer_id = :customer_id "
                    . " AND policy_parent_code = :policy_parent_code ";
            $edit_cri->params=array(
              ':account_id'=> Yii::app()->session['account_id'],
              ':customer_id'=> Yii::app()->session['customer_id'],
              ':policy_parent_code'=>$insurance_type
            );
            $edit_cri->order="id ASC";
            $all_coverage = CurrentCoverage::model()->findAll($edit_cri);
            if(!empty($all_coverage)):
                $check_c = new CDbCriteria;
                $row_ctr = 1;
                foreach($all_coverage as $allk => $allv):
                    if ($allv->policy_child_label == $first_child->policy_child_label) {
                        echo '<tr class="main-row">';
                    }
                    $check_c->condition = "account_id = :account_id AND policy_parent_label = :insurance_type AND policy_child_label = :policy_child_label";
                    $check_c->params=array(
                            ':insurance_type'=>$insurance_type, 
                            ':account_id'=> Yii::app()->session['account_id'],
                            ':policy_child_label'=>$allv->policy_child_label
                    );
                    $single_check = AccountSetupPolicy::model()->find($check_c);
                    echo '<td>';                     	  
                    echo '<select data-selected="'. $allv->policy_child_selected .'" record-id="'. $row_ctr .'" data-id="'. $allv->id .'" name="EditForm['. $allv->id .']" id="'. $allv->policy_child_label .'_'. $allv->id .'">';
                    $options = null;
                    if($single_check != null) {
                       
                       $default_value = $allv->policy_child_selected;
                       $options       = explode(',', $single_check->policy_child_values);
                       $cnt           = 0;
                       foreach ($options as $optkey => $optval) {
                           if ($cnt == 0) {
                               echo '<option value="'. $allv->policy_child_selected .'">'. $allv->policy_child_selected .'</option>';
                           }
                           $cnt++;
                           if ($optval != $default_value) {
                               $optval  = ($optval=='null') ? '' : $optval;
                               echo '<option value="'. $optval .'">'. $optval .'</option>';
                           }
                       }
                       echo '<option value="newvalue">(New Value)</option>';
                    }
                    echo '</select>';
                    echo '</td>';
            		
                    if ($allv->policy_child_label == $last_child->policy_child_label) {
                        echo '<td><button class="btn btn-default btn-delete" record-id="'. $row_ctr .'"><i class="fa fa-close"></i></button></td>';
                        echo '</tr>';
                        // increment row
                        $row_ctr = $row_ctr + 1;
                    }
                 endforeach;
            endif; // end:if($all_coverage != null):
            ?>
        </tbody>
      </table>
      
      <!-- New Record Template -->
      <script>
      <?php
      $tmpl = '';
      $tmpl .= '<input type="hidden" name="NewForm[section]" value="'. $insurance_type .'">';
      // Policy value selections
      $column_ctr = 0;
      foreach ($account_policies as $key => $value):
         $column_ctr++;
         $tmpl .= '<td>';
         $tmpl .= '<select name="TplForm['. $insurance_type .'][yyyy]['. $value->policy_child_label .']" data-key="xxxx" id="row_zzzz">';
         $tmpl .= '<option value="none" selected>(Select)</option>';
         $tmpl .= '<option value="newvalue">(New Value)</option>';
         $options = explode(',', $value->policy_child_values);
         if (count($options) >= 0) {
            foreach ($options as $key => $policy_value) {
                $policy_value = ($policy_value == 'null') ? '' : $policy_value;
                $tmpl .= '<option value="'. $policy_value .'">'. $policy_value .'</option>';
            }
         }
         $tmpl .= '</select>';
         $tmpl .= '</td>';
      endforeach;
    
      // Fill=up the remaining column
      for ($i=$column_ctr; $i <= $column_limit; $i++) {
          $tmpl .= '<td>&nbsp;</td>';
      }
      
      // Output
      echo "tpl_new_record['". $insurance_type ."'] = '". $tmpl ."';";
      ?>
      </script>
      <!-- End: New Record Template -->
      
      <p>&nbsp;</p>
      
      <!-- Action Buttons -->
      <table class="col-xs-8">
        <tr>
          <td colspan="3">
            <div class="col-xs-8">
              <div class="col-xs-3">
                  <button type="button" data-id="<?php echo $insurance_type; ?>" class="btn btn-warning btn-addpolicy">Add Policy</button>
              </div>
              <div class="col-xs-3">
                  <button type="button" data-id="<?php echo $insurance_type; ?>" class="btn btn-warning btn-savepolicy" style="display: none;">Save & Update</button>
              </div>
              <div class="col-xs-3">
                <button type="button" name="button" class="btn btn-primary  btn-action-item">Action Item</button>
              </div>
              <div class="col-xs-3">
                <button type="button" name="button" class="btn btn-primary  btn-add-note" data-dom=".page-note_<?php echo $insurance_type; ?>">Add Note</button>
              </div>
            </div>
          </td>
        </tr>
        <tr>
            <td colspan="4">
                <p class="page-note_<?php echo $insurance_type; ?>"></p>
            </td>
        </tr>            
      </table>
      
      
    </div>
  <?php
  endif;
  endforeach;
  ?>

  <div class="col-xs-12">
    <br>
  </div>

  <!-- footer buttons -->
  <div class="col-xs-12" style="margin-top: 2em;margin-bottom:2em;">
    <div class="col-xs-offset-2 col-xs-2">
    </div>
    <div class="col-xs-2">
    </div>
    <div class="col-xs-2">
      <button type="button" name="button" class="btn btn-warning btn-block " href="<?php echo Yii::app()->request->baseUrl; ?>/agentprep/step_dependents">Previous</button>
    </div>
    <div class="col-xs-2">
      <button type="button" name="button" class="btn btn-warning btn-block " href="<?php echo Yii::app()->request->baseUrl; ?>/agentprep/step_appointment">Next</button>
    </div>
  </div>
</div>

<script>
global_config.page_name="<?php echo basename(__FILE__, '.php'); ?>";
</script>

<?php
// custom script
Yii::app()->clientScript->registerScriptFile(
	Yii::app()->baseUrl . '/js/pages/agent_prep.js',
	CClientScript::POS_END
);
?>
