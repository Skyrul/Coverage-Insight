<?php
/* @var $this FeedbackController */
/* @var $model Feedback */

$this->breadcrumbs=array(
	'Feedbacks'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

?>

<div class="col-md-offset-4 col-md-4">

    
    <div class="row">
        <a href="<?php echo $this->moduleURL('feedback') .'/index'; ?>" class="btn btn-default">
        <i class="fa fa-chevron-circle-left" aria-hidden="true"></i> <?php echo $this->back_text; ?>
        </a><br>
        <h1>Update Feedback</h1>
        <p class="note">Fields with <span class="required">*</span> are required.</p>
    </div>
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>