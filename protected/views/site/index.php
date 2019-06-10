<?php 
// remove goto menu
$this->goto_menu = false;
?>
<style>
.row {
    margin-left: 20px;
    margin-right: 20px;
    margin-bottom: -13px !important;
}
.card-text {
    font-size: 1.8em;
    cursor: pointer;
}
.card {
    height: 184px;
    overflow-y: hidden;
}
</style>

<!-- 1st row -->
<div class="row">
  <div class="col-sm-3" id="D2">
    <div class="card text-center" href="<?php echo Yii::app()->createUrl('customer/listing?cmd=TODAY_APPOINTMENT'); ?>">
      <div class="card-block">
        <h3 class="card-title card1">0</h3>
        <p class="card-text">Today's Appointment</p>
      </div>
    </div>
  </div>
  <div class="col-sm-3" id="D3">
    <div class="card text-center" href="<?php echo Yii::app()->createUrl('account/action_item?cmd=SALES_OPPORTUNITIES'); ?>">
      <div class="card-block">
        <h3 class="card-title card2">0</h3>
        <p class="card-text">Sales Opportunities</p>
      </div>
    </div>
  </div>
  <div class="col-sm-3" id="D4">
    <div class="card text-center" href="<?php echo Yii::app()->createUrl('customer/listing?cmd=MISSING_AP'); ?>">
      <div class="card-block">
        <h3 class="card-title card3">0</h3>
        <p class="card-text">Appts Missing Agent Prep</p>
      </div>
    </div>
  </div>
  <div class="col-sm-3" id="D5">
    <div class="card text-center" href="<?php echo Yii::app()->createUrl('customer/listing'); ?>">
      <div class="card-block">
        <h3 class="card-title">
                <i class="fa fa-plus"></i><br>
        </h3>
        <p class="card-text">Add New Customer</p>
      </div>
    </div>
  </div>
</div>
<!-- end:1st row -->
<p>&nbsp;</p>
<!-- 2nd row -->
<div class="row">
  <div class="col-sm-3" id="D6">
    <div class="card text-center"  href="<?php echo Yii::app()->createUrl('customer/listing?cmd=FUTURE_APPOINTMENT'); ?>">
      <div class="card-block">
        <h3 class="card-title card4">0</h3>
        <p class="card-text">Future Appointments</p>
      </div>
    </div>
  </div>
  <div class="col-sm-3" id="D7">
    <div class="card text-center" href="<?php echo Yii::app()->createUrl('account/action_item?cmd=OPEN_ACTION_ITEMS'); ?>">
      <div class="card-block">
        <h3 class="card-title card5">0</h3>
        <p class="card-text">Open Action Items</p>
      </div>
    </div>
  </div>
  <div class="col-sm-3" id="D8">
    <div class="card text-center" href="<?php echo Yii::app()->createUrl('customer/listing?cmd=MISSING_NA'); ?>">
      <div class="card-block">
        <h3 class="card-title card6">0</h3>
        <p class="card-text">Appts Missing Needs Assessment</p>
      </div>
    </div>
  </div>
  <div class="col-sm-3" id="D9">
    <div class="card text-center" href="<?php echo Yii::app()->createUrl('account/setup'); ?>">
      <div class="card-block">
        <h3 class="card-title">
                <i class="fa fa-gear"></i><br>
        </h3>
        <p class="card-text">Account Setup</p>
      </div>
    </div>
  </div>
</div>
<!-- end:2nd row -->

<?php 
Yii::app()->clientScript->registerScriptFile(
	Yii::app()->baseUrl . '/js/pages/dashboard.js', 
	CClientScript::POS_END
); ?>