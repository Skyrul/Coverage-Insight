<?php
/* @var $this PromoController */
/* @var $data Promo */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('promo_name')); ?>:</b>
	<?php echo CHtml::encode($data->promo_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('promo_code')); ?>:</b>
	<?php echo CHtml::encode($data->promo_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('amount_off')); ?>:</b>
	<?php echo CHtml::encode($data->amount_off); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('valid_num_months')); ?>:</b>
	<?php echo CHtml::encode($data->valid_num_months); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />


</div>