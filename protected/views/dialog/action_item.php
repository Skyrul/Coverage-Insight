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
        'id'=>'action-item-form',
        'focus'=>array($model, 'action_type_code')
    ));
    ?>    
    <table class="col-xs-7">
        <thead>
            <tr>
                <td class="col-xs-2">Type</td>
                <td class="col-xs-4">Item Description</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <?php
            if (!empty($action_item)):
                foreach($action_item as $key=>$value):
                ?>
                <tr>
                    <td>
                        <?php echo $form->hiddenField($model, '['. $key .']id', array('value'=>$value->id)); ?>
                        <?php echo $form->textField($model, '['. $key .']action_type_code', array('class'=>'text-control','value'=>$value->action_type_code, 'readonly'=>true, 'style'=>'background-color:lightgray;')); ?>
                    </td>
                    <td>
                        <?php echo $form->textField($model, '['. $key .']description', array('class'=>'text-control','value'=>$value->description, 'readonly'=>true, 'style'=>'background-color:lightgray;')); ?>
                    </td>
                </tr>
                <?php
                endforeach;
            endif;
            ?>
            <tr>
                <td>
                    <?php $new_ctr = count($action_item)+1; ?>
                    <?php echo $form->hiddenField($model, '['. $new_ctr .']id'); ?>
                    <?php echo $form->textField($model, '['. $new_ctr .']action_type_code', array('class'=>'text-control', 'placeholder'=>'Action Type','id'=>'action_type_code')); ?>
                </td>
                <td>
                    <?php echo $form->textField($model, '['. $new_ctr .']description', array('class'=>'text-control', 'placeholder'=>'Description')); ?>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">
                    <button id="btn-add-action-item" type="button" class="btn btn-warning">Save Item</button>
                </td>
            </tr>
        </tfoot>
    </table>
    
    <?php $this->endWidget(); ?>
</div>

<script>
    function add_action_item(e) 
    {
        e.preventDefault;
        var param = $('#action-item-form').serialize();
        $.post(global_config.base_url + '/dialog/action_item', param, function(data) {
            if(data.status=='success') {
                msgbox('success', data.json);
                dialogbox('Action Items', '/dialog/action_item', 'hide');
            } else {
                alert(data.description);
            }
        });
    }
    function close_dialog() 
    {
        $(global_config.dlg).modal('hide')
    }
    
    !(function() {
        $(document).ready(function() {
            $('#btn-add-action-item').on('click', add_action_item);
            var label = $('.page-sub-label').text()
            $('#action_type_code').val(label);
        });
    })();
    </script>