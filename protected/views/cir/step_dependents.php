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
              <?php if (count($model) == 0): ?>
              <tr id="no-record-status">
              	<td colspan="2"><h4 class="text-center">No Current Record</h4></td>
              </tr>
              <?php endif; ?>
              
              <?php foreach($model as $key => $value): ?>
              <?php echo CHtml::beginForm('', 'post', array('id'=>'FormEdit_'. $value->id)); ?>
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
                      <button type="button" name="button" class="btn btn-default btn-sm btn-remove" href="<?php Yii::app()->request->baseUrl; ?>/<?php echo $this->id; ?>/dependent_delete?id=<?php echo CHtml::encode($value->id); ?>"><i class="fa fa-close"></i></button>
                    </td>
                  </tr>
              <?php echo CHtml::endForm(); ?>
              <?php endforeach; ?>

              <?php echo CHtml::beginForm('', 'post', array('id'=>'NewForm')); ?>
                  <tr id="new-form" style="display: none;">
                    <input type="hidden" name="DependentNew[action]" value="New">
                    <td>
                      <?php echo CHtml::textField('DependentNew[dependent_name]', null, array('placeholder'=>'Name of your dependent', 'class'=>'Lfocus-Add')); ?>
                    </td>
                    <td>
                      <?php
                        echo CHtml::dropDownList('DependentNew[dependent_age]', CHtml::encode(10), Dependent::model()->listAges(), array('class'=>'Lfocus-Add'));
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">
                      <button id="btn-add-dependent" type="button" name="button" class="btn btn-warning">Add Dependent</button>
                    </td>
                  </tr>
              <?php echo CHtml::endForm(); ?>

            </tbody>
          </table>
    </div>
  </div>

  <div class="col-xs-12">
      <div class="col-xs-offset-2 col-xs-8">
          <p class="page-note"></p>
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