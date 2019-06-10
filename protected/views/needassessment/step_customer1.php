<?php
// NA
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
            <?php echo $form->textField($model, 'primary_telno', array('required'=>true, 'class'=>'phone-mask')); ?>
          </td>
        </tr>
        <tr>
          <td><label class="step">Cell Phone Number:</label></td>
          <td>
            <?php echo $form->textField($model, 'primary_cellphone', array('class'=>'phone-mask')); ?>
          </td>
        </tr>
        <tr>
          <td><label class="step">Alt Phone Number:</label></td>
          <td>
            <?php echo $form->textField($model, 'primary_alt_telno', array('class'=>'phone-mask')); ?>
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
    </div>
  </div>

  <!-- footer buttons -->
  <div class="col-xs-12" style="margin-bottom:1em;">
    <div class="col-xs-offset-2 col-xs-2">
    </div>
    <div class="col-xs-2">
      <?php
        echo CHtml::button('Previous', array(
            'submit'=>'?customer_id='. $customer->id .'&direction=prev',
            'class'=>'btn btn-primary btn-block',
        ));
      ?>
    </div>
    <div class="col-xs-2">
      <button type="button" name="button" class="btn btn-primary btn-block" href="<?php echo Yii::app()->request->baseUrl; ?>/<?php echo $this->id; ?>/step_customer2">Skip</button>
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
