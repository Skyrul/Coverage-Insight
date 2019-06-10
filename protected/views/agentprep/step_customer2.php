<?php
$this->with_progressbar = true;
$this->progress_bar = array('start'=>'20', 'end'=>'80');
$this->page_label = $customer->primary_firstname.' '.$customer->primary_lastname.''.
                    (($customer->secondary_firstname) ? ' & '.$customer->secondary_firstname.' '.$customer->secondary_lastname : '');
?>
<style>
  .form-control {
    width: 34em;
    margin-bottom: 10px;
  }
</style>

<div class="container">
  <div class="col-xs-12">
    <div class="page-sub-label text-center">Secondary Contact Information</div>
    <p>&nbsp;</p>
  </div>
  <?php
      $form=$this->beginWidget('CActiveForm', array(
        'id'=>'customer-form',
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
          <td><label class="step">Secondary First Name:</label></td>
          <td>
            <?php echo $form->textField($model, 'secondary_firstname', array('required'=>false)); ?>
          </td>
        </tr>
        <tr>
          <td><label class="step">Secondary Last Name:</label></td>
          <td>
            <?php echo $form->textField($model, 'secondary_lastname', array('required'=>false)); ?>
          </td>
        </tr>
        <tr>
          <td><label class="step">Home Phone Number:</label></td>
          <td>
            <?php echo $form->textField($model, 'secondary_telno', array('required'=>false, 'class'=> 'phone-mask')); ?>
          </td>
        </tr>
        <tr>
          <td><label class="step">Cell Phone Number:</label></td>
          <td>
            <?php echo $form->textField($model, 'secondary_cellphone', array('class'=> 'phone-mask')); ?>
          </td>
        </tr>
        <tr>
          <td><label class="step">Alt Phone Number:</label></td>
          <td>
            <?php echo $form->textField($model, 'secondary_alt_telno', array('class'=> 'phone-mask')); ?>
          </td>
        </tr>
        <tr>
          <td><label class="step">Email:</label></td>
          <td>
            <?php echo $form->textField($model, 'secondary_email', array('required'=>false)); ?>
          </td>
        </tr>
        <tr>
          <td><label class="step">Emergency Contact:</label></td>
          <td>
            <?php echo $form->textField($model, 'secondary_emergency_contact'); ?>
          </td>
        </tr>
      </table>
      <p>&nbsp;</p>
      <p class="page-note"></p>
    </div>
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
<!--      <button type="submit" name="button" class="btn btn-warning btn-block" href="<?php echo Yii::app()->request->baseUrl; ?>/agentprep/step_customer1?customer_id=<?php echo Yii::app()->session['customer_id']; ?>">Previous</button>-->
      <?php echo CHtml::button('Previous', array(
          'submit'=>'?direction=previous',
          'class'=>'btn btn-warning btn-block'
      )); ?>
    </div>
    <div class="col-xs-2">
<!--      <button type="submit" name="button" class="btn btn-warning btn-block" >Next</button>-->
      <?php echo CHtml::button('Next', array(
          'submit'=>'?direction=next',
          'class'=>'btn btn-warning btn-block'
      )); ?>
    </div>
  </div>
  <?php $this->endWidget(); ?>
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
