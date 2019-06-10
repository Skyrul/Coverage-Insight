<?php
$this->with_progressbar = true;
$this->progress_bar = array('start'=>'10', 'end'=>'90');
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
    <div class="page-sub-label text-center">Customer Contact Information</div>
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
          <td><label class="step">Primary First Name:<span class="is-required">*</span></label></td>
          <td>
            <?php echo $form->textField($model, 'primary_firstname'); ?>
          </td>
        </tr>
        <tr>
          <td><label class="step">Primary Last Name:<span class="is-required">*</span></label></td>
          <td>
            <?php echo $form->textField($model, 'primary_lastname'); ?>
          </td>
        </tr>
        <tr>
          <td><label class="step">Home Phone Number:<span class="is-required">*</span></label></td>
          <td>
            <?php echo $form->textField($model, 'primary_telno', array('required'=>true, 'class'=> 'phone-mask')); ?>
          </td>
        </tr>
        <tr>
          <td><label class="step">Cell Phone Number:</label></td>
          <td>
            <?php echo $form->textField($model, 'primary_cellphone', array('class'=> 'phone-mask')); ?>
          </td>
        </tr>
        <tr>
          <td><label class="step">Alt Phone Number:</label></td>
          <td>
            <?php echo $form->textField($model, 'primary_alt_telno', array('class'=> 'phone-mask')); ?>
          </td>
        </tr>
        <tr>
          <td><label class="step">Email:<span class="is-required">*</span></label></td>
          <td>
            <?php echo $form->textField($model, 'primary_email', array('required'=>true)); ?>
          </td>
        </tr>
        <tr>
          <td><label class="step">Emergency Contact:</label></td>
          <td>
            <?php echo $form->textField($model, 'primary_emergency_contact'); ?>
          </td>
        </tr>
      </table>
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
      <button type="button" name="button" class="btn btn-primary btn-block " href="<?php echo Yii::app()->request->baseUrl; ?>/customer/listing">Back</button>
    </div>
    <div class="col-xs-2">
      <button type="submit" name="button" class="btn btn-warning btn-block ">Next</button>
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
