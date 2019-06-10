<?php
/* @var $this PromoController */
/* @var $model Promo */

$this->breadcrumbs=array(
	'Promos'=>array('index'),
	'Create',
);

?>

<div class="col-md-offset-4 col-md-4">
    <a href="<?php echo $this->moduleURL('promo') .'/index'; ?>" class="btn btn-default">
    <i class="fa fa-chevron-circle-left" aria-hidden="true"></i> <?php echo $this->back_text; ?>
    </a>
    
    <h1>Create Promo</h1><br>
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>