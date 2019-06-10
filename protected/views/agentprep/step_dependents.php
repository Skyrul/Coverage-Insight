<?php
$this->with_progressbar = true;
$this->progress_bar = array('start'=>'30', 'end'=>'70');
$this->page_label = $customer->primary_firstname.' '.$customer->primary_lastname.''.
                    (($customer->secondary_firstname) ? ' & '.$customer->secondary_firstname.' '.$customer->secondary_lastname : '');
?>
<style>
  .form-control {
    margin-bottom: 10px;
  }
  .select2-container--default {
      width: 100% !important;
      margin-left: 6px;
      margin-bottom: 1em;
      border: 1px solid;
  }
  .btn-remove {
    margin-bottom: 12px;
    margin-left: 8px;
  }
</style>

<div class="container">
  <div class="col-xs-12">
    <div class="page-sub-label text-center">Dependents</div>
    <p>&nbsp;</p>
  </div>

  <div class="col-xs-12">
    <?php echo CHtml::errorSummary($model); ?>
  </div>

  <div class="col-xs-12">
    <div class="col-xs-offset-3">
          <table class="col-xs-8" border="0">
            <thead>
              <tr>
                <td class="step-head text-center">Name</td>
                <td class="step-head">&nbsp;Age</td>
              </tr>
            </thead>
            <tbody>
              <?php foreach($model as $key => $value): ?>
              <?php echo CHtml::beginForm('', 'post', array('id'=>'FormEdit_'.$value->id )); ?>
                <input type="hidden" name="DependentEdit[action]" value="Edit">
                <?php echo CHtml::hiddenField('DependentEdit[id]', $value->id); ?>
                  <tr>
                    <td>
                      <?php echo CHtml::textField('DependentEdit[dependent_name]', $value->dependent_name, array('class'=>'Lfocus', 'data-id'=>$value->id)); ?>
                    </td>
                    <td>
                      <?php
                        echo CHtml::dropDownList('DependentEdit[dependent_age]', CHtml::encode($value->dependent_age), Dependent::model()->listAges(), array('class'=>'Lfocus', 'data-id'=>$value->id));
                      ?>
                    </td>
                    <td>
                      <button type="button" name="button" class="btn btn-default btn-sm btn-remove" href="<?php Yii::app()->request->baseUrl; ?>/api/dependent_delete?id=<?php echo CHtml::encode($value->id); ?>"><i class="fa fa-close"></i></button>
                    </td>
                  </tr>
              <?php echo CHtml::endForm(); ?>
              <?php endforeach; ?>
              <?php if (empty($model)): ?>
                  <tr>
                      <td colspan="12">
                          <h4 class="text-center no-rec">No current record</h4>
                      </td>
                  </tr>
              <?php endif; ?>
                  <script>
                  var new_record = '';
                  new_record += '<tr>';
                  new_record += '<input type="hidden" name="DependentNew[action]" value="New">';
                  new_record += '<td>';
                  new_record += '<?php echo CHtml::textField('DependentNew[dependent_name]', null, array('placeholder'=>'Name of your dependent', 'class'=>'Lfocus-Add')); ?>';
                  new_record += '</td>';
                  new_record += '<td>';
                  new_record += '<?php echo preg_replace( "/\r|\n/", "", CHtml::dropDownList('DependentNew[dependent_age]', CHtml::encode(10), Dependent::model()->listAges(), array('class'=>'Lfocus-Add'))); ?>';
                  new_record += '</td>';
                  new_record += '</tr>';
                  global_config.new_record = new_record;
                  </script>
                  <tr id="new-form">
                    <td colspan="2">
                      <?php echo CHtml::button('Add Dependent', array('class'=>'btn btn-warning', 'id'=> 'btn-add-dependent')); ?>
                    </td>
                  </tr>

            </tbody>
          </table>
    </div>
  </div>

    <p class="clear">&nbsp;</p>
    
    <div class="col-xs-offset-3">
      <p class="page-note"></p>
    </div>
    
  <!-- footer buttons -->
  <div class="col-xs-12">
    <div class="col-xs-offset-2 col-xs-2">
      <button type="button" name="button" class="btn btn-primary btn-block  btn-action-item">Action Item</button>
    </div>
    <div class="col-xs-2">
      <button type="button" name="button" class="btn btn-primary btn-block  btn-add-note">Add Note</button>
    </div>
    <div class="col-xs-2">
      <button type="button" name="button" class="btn btn-warning btn-block " href="<?php echo Yii::app()->request->baseUrl; ?>/agentprep/step_customer2">Previous</button>
    </div>
    <div class="col-xs-2">
      <button type="button" name="button" class="btn btn-warning btn-block " href="<?php echo Yii::app()->request->baseUrl; ?>/agentprep/step_current_coverages">Next</button>
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