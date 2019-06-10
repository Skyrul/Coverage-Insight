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
    height: 160px;
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
  <div class="col-sm-3">
    <div class="card text-center" href="<?php echo Yii::app()->createUrl('admin/feedback/index'); ?>">
      <div class="card-block">
        <h3 class="card-title">
                <i class="fa fa-comments"></i><br>
        </h3>
        <p class="card-text">Feedback</p>
      </div>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="card text-center" href="<?php echo Yii::app()->createUrl('admin/auditlogs/index'); ?>">
      <div class="card-block">
        <h3 class="card-title">
                <i class="fa fa-file-text-o"></i><br>
        </h3>
        <p class="card-text">Audit Log</p>
      </div>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="card text-center" href="<?php echo Yii::app()->createUrl('admin/promo/index'); ?>">
      <div class="card-block">
        <h3 class="card-title">
                <i class="fa fa-ticket"></i><br>
        </h3>
        <p class="card-text">Promo Management</p>
      </div>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="card text-center" href="<?php echo Yii::app()->createUrl('admin/configuration/index'); ?>">
      <div class="card-block">
        <h3 class="card-title">
                <i class="fa fa-gear"></i><br>
        </h3>
        <p class="card-text">Configuration</p>
      </div>
    </div>
  </div>
  <?php endif; ?>
</div>


<!-- end:1st row -->
<p>&nbsp;</p>
<!-- 2nd row -->
<div class="row">
  <div class="col-sm-3">
    <div class="card text-center" href="<?php echo Yii::app()->createUrl('admin/billings/index'); ?>">
      <div class="card-block">
        <h3 class="card-title">
                <i class="fa fa-file-text-o"></i><br>
        </h3>
        <p class="card-text">Billing History</p>
      </div>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="card text-center" href="#!">
      <div class="card-block">
        <h3 class="card-title">
                <i class="fa fa-user-circle-o"></i><br>
        </h3>
        <p class="card-text">Referral Manager</p>
      </div>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="card text-center" href="<?php echo Yii::app()->createUrl('admin/enrollmentcancelrpt/index'); ?>">
      <div class="card-block">
        <h3 class="card-title">
                <i class="fa fa-handshake-o"></i><br>
        </h3>
        <p class="card-text">Enrollment/Cancel Report</p>
      </div>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="card text-center" href="<?php echo Yii::app()->createUrl('admin/site/logout'); ?>">
      <div class="card-block">
        <h3 class="card-title">
                <i class="fa fa-sign-out"></i><br>
        </h3>
        <p class="card-text">Log-Out</p>
      </div>
    </div>
  </div>
</div>

<?php 
Yii::app()->clientScript->registerScriptFile(
	Yii::app()->baseUrl . '/admin/assets/js/pages/dashboard.js', 
	CClientScript::POS_END
); ?>