<?php
if (!$this->is_superuser()):
    echo 'No permission to view';
    exit;
endif; 
?>
<style>
.row {
    margin-left: 20px;
    margin-right: 20px;
    margin-bottom: -13px !important;
}
.card-text {
    font-size: 1.6em;
    cursor: pointer;
}
.card {
    height: 140px;
    overflow-y: hidden;
}
.feedback {
    display: none;
}
.fa {
    color: rgba(75, 117, 180, 1);
}
</style>

<!-- 1st row -->
<div class="row">
  <?php if ($this->is_superuser()):?>
  
  <div class="col-sm-2">
    <div class="card text-center" href="<?php echo Yii::app()->createUrl('admin/site/index'); ?>">
      <div class="card-block">
        <h3 class="card-title">
                <i class="fa fa-chevron-left"></i><br>
        </h3>
        <p class="card-text">Back to Dashboard</p>
      </div>
    </div>
  </div>
  
  <div class="col-sm-2">
    <div class="card text-center" href="<?php echo Yii::app()->createUrl('admin/charges/index'); ?>">
      <div class="card-block">
        <h3 class="card-title">
                <i class="fa fa-sliders"></i><br>
        </h3>
        <p class="card-text">Fees and Charges</p>
      </div>
    </div>
  </div>
  
  <div class="col-sm-2">
    <div class="card text-center" href="<?php echo Yii::app()->createUrl('admin/anetsetting/update'); ?>">
      <div class="card-block">
        <h3 class="card-title">
                <i class="fa fa-credit-card"></i><br>
        </h3>
        <p class="card-text">Authorize.Net</p>
      </div>
    </div>
  </div>

  <div class="col-sm-2">
    <div class="card text-center" href="<?php echo Yii::app()->createUrl('admin/virtualincentives/update'); ?>">
      <div class="card-block">
        <h3 class="card-title">
                <i class="fa fa-gear"></i><br>
        </h3>
        <p class="card-text">Virtual Incentives</p>
      </div>
    </div>
  </div>
  <?php else:?>
    <div class="col-sm-12">
      <p class="text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>&nbsp;No permission to view</p>
    </div>
  <?php endif; ?>
</div>

<?php 
Yii::app()->clientScript->registerScriptFile(
	Yii::app()->baseUrl . '/admin/assets/js/pages/dashboard.js', 
	CClientScript::POS_END
); ?>