<?php 
if (!$this->is_superuser()):
?>
  <div class="col-sm-12">
  	<p class="text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>&nbsp;No permission to view</p>
  </div>
<?php
exit;
endif; 
?>

<style>
.successSummary
{
    border: 2px solid #CDDC39;
    padding: 7px 7px 12px 7px;
    margin: 0 0 20px 0;
    background: #fbfde5;
    font-size: 12px;
}
</style>

<div class="col-md-offset-4 col-md-4">
    <a href="<?php echo $this->moduleURL('configuration') .'/index'; ?>" class="btn btn-default">
    <i class="fa fa-chevron-circle-left" aria-hidden="true"></i> <?php echo $this->back_text; ?>
    </a>
    
    <br>
    <h1 class="text-center">Virtual Incentives</h1><br>
    <span>Note: You also need to make sure that your website IP address is whitelisted to Virtual Incentives API Server. IP whitelisting can be requested by email check API documentation for more information</span>
    <?php if ($model->is_sandbox == EnumStatus::PRODUCTION): ?>
    	<div class="successSummary">
    		<i class="fa fa-info-circle" aria-hidden="true"></i> You are currently in <strong>PRODUCTION</strong> mode user making payment should use Real Credit Cards for ordering
    	</div>		
    <?php elseif ($model->is_sandbox == EnumStatus::SANDBOX): ?>
    	<div class="errorSummary">
    		<i class="fa fa-info-circle" aria-hidden="true"></i> You are currently in <strong>DEVELOPMENT(SANDBOX)</strong> mode you can use Test Credit Cards when ordering
    	</div>
    <?php endif; ?>
    
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>