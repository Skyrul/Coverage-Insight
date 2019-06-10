<style>
.form-horizontal .form-group {
    margin-right: -67px;
}
</style>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'feedback-form',
    'enableAjaxValidation'=>false,
));?>

    <div class="row">
        <div class="errorMessage"></div>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($model, 'created_at'); ?><br>
        <strong style="color:blue;"><?php echo date('m/d/Y H:i:s', strtotime($model->created_at)); ?></strong>
        <?php echo $form->error($model, 'created_at'); ?>

    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'reporter_email'); ?>
        <?php
        echo $form->textField($model, 'reporter_email', array('size' => 60,
            'maxlength' => 255,
            'class' => 'form-control required',
            'placeholder' => '',
            'onkeypress'=>'return false'));
        ?>
        <?php echo $form->error($model, 'reporter_email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'page_url'); ?>
        <?php
        echo $form->textField($model, 'page_url', array('class' => 'form-control required',
            'placeholder' => '',
            'onkeypress'=>'return false'));
        ?>
        <?php echo $form->error($model, 'page_url'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'message'); ?>
        <?php
        echo $form->textArea($model, 'message', array('rows' => 10,
            'cols' => 50,
            'class' => 'form-control',
            'placeholder' => 'Provide your feedback message here..'));
        ?>
        <?php echo $form->error($model, 'message'); ?>
    </div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status', array(
		    'OPEN'=>'OPEN',
		    'CLOSED'=>'CLOSED',
            'RESOLVED'=>'RESOLVED',
            'UNRESOLVED'=>'UNRESOLVED',
            'PENDING'=>'PENDING',
            'REVIEW'=>'REVIEW',
		)); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>
    
    <div class="row">
        <strong>Attachment(s):</strong><br>
        <?php
        $attachments = FeedbackAttachment::model()->findAll('feedback_id = :id', array(
            ':id'=>$model->id
        ));
        if(!empty($attachments)) {
            $ctr=0;
            foreach($attachments as $kk=>$vv){
                $ctr++;
                echo '<a href="'. $this->programURL() .'/feedback/'. $vv->attachment .'">'. $vv->attachment .'</a><br>';
            }
        }
        ?>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary btn-block')); ?>
	</div>


<?php $this->endWidget(); ?>