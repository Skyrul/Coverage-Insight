<style>
    .text-control {
        padding: 8px;
        width: 98%;
        border-radius: 0px;
        border: 1px solid gray;
        margin-bottom: 8px;
    }
</style>

<div class="row">   
    <?php
    $form= $this->beginWidget('CActiveForm', array(
        'id'=>'add-note-form'
    ));
    ?>    
    <table class="col-xs-8">
        <thead>
            <tr>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <?php
            $cr1 = new CDbCriteria;
            $cr1->condition = 'account_id = :id AND customer_id = :cid';
            $cr1->params = array(
                ':id'=>Yii::app()->session['account_id'],
                ':cid'=>Yii::app()->session['customer_id'],
            );
            $note = Note::model()->findAll($cr1);
            if (!empty($note)):
                foreach($note as $key=>$value):
                ?>
                <tr>
                    <td>
                        <?php echo $form->hiddenField($model, '['. $key .']id', array('value'=>$value->id)); ?>
                        <?php echo $form->hiddenField($model, '['. $key .']page_url', array('value'=>$value->page_url, 'class'=>'page_url')); ?>
                        <?php echo $form->hiddenField($model, '['. $key .']dom_element', array('value'=>$value->dom_element)); ?>
                        <?php echo $form->textField($model, '['. $key .']msg_note', array('rows'=>2,'cols'=>20, 'class'=>'text-control', 'readonly'=>true, 'style'=>'background-color:#fffcf2;', 'value'=> $value->msg_note )); ?>
                    </td>
                    <td>
                        <button type="button" data-id="<?php echo $value->id; ?>" class="btn btn-default btn-delete-note" style="margin-bottom: 10px;"><i class="fa fa-close"></i></button>
                    </td>
                </tr>
                <?php
                endforeach;
            else:
            ?>
            <tr>
                <td>
                    <?php $new_ctr = count($note)+1; ?>
                    <?php echo $form->hiddenField($model, '['. $new_ctr .']id'); ?>
                    <?php echo $form->hiddenField($model, '['. $new_ctr .']page_url', array('class'=>'page_url')); ?>
                    <?php echo $form->hiddenField($model, '['. $new_ctr .']dom_element', array('class'=>'dom_element')); ?>
                    <?php echo $form->textArea($model, '['. $new_ctr .']msg_note', array('rows'=>2,'cols'=>15, 'class'=>'text-control', 'placeholder'=>'Your Notes Here..')); ?>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <button id="btn-add-note" type="button" class="btn btn-warning">Add Note</button>
                </td>
            </tr>
            <?php
            endif;
            ?>
        </tbody>
        <tfoot>

        </tfoot>
    </table>
    <?php $this->endWidget(); ?>
</div>

<div class="row">
	<p style="color: red;">**Notes that agent enters here will be visible to the customer during the CIR</p>
</div>

<script>
    function add_note(e) 
    {
        e.preventDefault;
        var param = $('#add-note-form').serialize();
        $.post(global_config.base_url + '/dialog/add_note', param, function(data) {
            if(data.status==='success') {
                //dialogbox('', '', 'hide');
                msgbox('success', data.json + ' Reloading page..');
                setTimeout(function() {
                    location.reload();
                }, 1000);
            } else {
                alert(errorText(data));
            }
        });
    }
    function delete_note(e) 
    {
        e.preventDefault;
        var param = {
            'id': $(this).attr('data-id')
        };
        $.post(global_config.base_url + '/api/notes_delete', param, function(data) {
            if(data.status==='success') {
                msgbox('success', data.json);
                setTimeout(function() {
                    location.reload();
                }, 1000);
            } else {
                alert(errorText(data));
            }
        });
    }
    function close_dialog() 
    {
        $(global_config.dlg).modal('hide')
    }
    
    !(function() {
        $(document).ready(function() {
            $('#btn-add-note').on('click', add_note);
            $('.btn-delete-note').on('click', delete_note);
            
            // data specific for this page
            //var label = $('.page-sub-label').text()
            var sections = '';
            if (typeof global_config.notes_sections === 'undefined') {
                sections = '.page-note';
            } else {
                sections = global_config.notes_sections;
            }
            $('.dom_element').val(sections);
            $('.page_url').val(global_config.current_url);
        });
    })();
    </script>