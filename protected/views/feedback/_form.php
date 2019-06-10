<style>
.feedback-container {
    width: 50%;
    display: block;
}
</style>


<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'feedback-form',
    'action' => array('feedback/create'),
    'enableAjaxValidation'=>false,
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
));
?>

<div class="feedback-container">
    <div class="pull-right">
    <a href="<?php echo $this->programURL(); ?>/feedback/viewall" style="text-align:right;display:inline-block;"><i class="fa fa-sort"></i> View All Previous Feedback</a>
    &nbsp;
    <a href="#!" onclick="guideline()" style="text-align:right;display:inline-block;"><i class="fa fa-question"></i> Feedback Quick Guideline</a>
    </div>
    <script>
        function guideline() {
            var msg = "To properly address and speed-up the resolve of your feedback, it would be great if you can include following details:\n\n";
            msg += "- Indicate the Browser you use (example: Firefox, Chrome, Internet Explorer)";
            msg += "   also include version number if possible\n\n";
            msg += "- Attached the page-screenshot of the issue to help us reproduce\n\n";
            msg += "- Attached the GIF screen of help us reproduce (Refer to this Free tool: https://www.cockos.com/licecap/)\n\n";
            alert(msg);
        }
    </script>
    <div class="form-group">
        <div class="errorMessage"></div>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'reporter_email'); ?>
        <?php
        echo $form->textField($model, 'reporter_email', array('size' => 60,
            'maxlength' => 255,
            'class' => 'form-control required',
            'placeholder' => '',
            'value' => Yii::app()->user->name,
            'onkeypress'=>'return false'));
        ?>
        <?php echo $form->error($model, 'reporter_email'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'created_at'); ?>
        <?php
        echo $form->textField($model, 'created_at', array('class' => 'form-control required',
            'placeholder' => '',
            'value' => date('m/d/Y H:i:s'),
            'onkeypress'=>'return false'));
        ?>
        <?php echo $form->error($model, 'created_at'); ?>

    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'page_url'); ?>
        <?php
        echo $form->textField($model, 'page_url', array('class' => 'form-control required',
            'placeholder' => '',
            'value' => '',
            'onkeypress'=>'return false'));
        ?>
        <?php echo $form->error($model, 'page_url'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'message'); ?>
        <?php
        echo $form->textArea($model, 'message', array('rows' => 10,
            'cols' => 50,
            'class' => 'form-control',
            'placeholder' => 'Provide your feedback message here..'));
        ?>
        <?php echo $form->error($model, 'message'); ?>
    </div>
    <div class="form-group">
        <div class="col-sm-6">
            <?php echo $form->labelEx($model, 'image'); ?>
            <?php
            echo $form->fileField($model, 'image');
            ?>
            <?php echo $form->error($model, 'image'); ?>
        </div>
        <div class="col-sm-6">
            <?php echo CHtml::button('Submit this Feedback', array('id'=>'btn-feedback-post', 'type'=>'button', 'class' => 'btn btn-warning pull-right')); ?>
        </div>
    </div>
    <div class="form-group">
    
    </div>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    (function () {
        if (window.store) {
            $('#Feedback_page_url').val(store.get('current_url'));
        }
        
        $('#btn-feedback-post').on('click', function(e) {
            e.preventDefault;

            var formData = new FormData($('#feedback-form')[0]); 
            $.ajax({
                url: global_config.base_url + '/feedback/create',
                type: 'POST',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data.status==='success') {
                        dialogbox('','','hide');
                        setTimeout(function() {
                            dialogbox('Feedback Submitted!', global_config.base_url + '/feedback/thank_you', 'show');
                        }, 1000);
                    } else {
                        $('.errorMessage').html(data.json);
                    }
                }
            });
            // var param = $('#feedback-form').serialize();
            // $.post(global_config.base_url + '/feedback/create', param, function(data) {
            //     if (data.status==='success') {
            //         dialogbox('','','hide');
            //         setTimeout(function() {
            //             dialogbox('Feedback Submitted!', global_config.base_url + '/feedback/thank_you', 'show');
            //         }, 1000);
            //     } else {
            //         $('.errorMessage').html(data.json);
            //     }
            // });
        });
    })();
</script>
