<style>
   .text-control {
        padding: 8px;
        width: 98%;
        border-radius: 0px;
        border: 1px solid gray;
        margin-bottom: 8px;
   }
    
  .select2-container--default {
    width: 148px !important;
    height: 36px;
    margin-left: 6px;
    margin-bottom: 0.7em;
    padding-top: 4px;
    background-color: white;
    border: 1px solid gray;
  }
  
  .concernAdd {
      background-color: #fdf3e1;
  }
</style>

<div class="row">   
    <table class="col-xs-7">
        <thead>
            <tr>
                <td class="col-xs-2">Type</td>
                <td class="col-xs-8">Item Description</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>&nbsp;</td>
            </tr>

            <?php
            // Edit saved record
            if (!empty($goals_concerns)):
                foreach($goals_concerns as $key=>$value):
                ?>
                    <tr id="<?php echo "goals-concerns-editform".$key; ?>">
                        <td>
                            <?php echo CHtml::hiddenField('GoalsConcern['. $key .'][id]', $value->id, array('data-id'=>$key)); ?>
                            <?php echo CHtml::dropDownList('GoalsConcern['. $key .'][action_type]', CHtml::encode($value->action_type), array('Goal'=>'Goal', 'Concern'=>'Concern'), array('class'=>'cLfocus', 'data-id'=>$key)); ?>
                        </td>
                        <td>
                            <?php echo CHtml::textField('GoalsConcern['. $key .'][action_description]', CHtml::encode($value->action_description), array('class'=>'text-control cLfocus', 'data-id'=>$key)); ?>
                        </td>
                    </tr>
                <?php
                endforeach;
            endif;
            ?>                
                
            <?php
            // Add Mode
            $form= $this->beginWidget('CActiveForm', array(
                'id'=>'goals-concerns-form'
            ));
            ?>
                    <tr style="border-top:1px solid"><td colspan="10">&nbsp;</td></tr>
            <tr>
                <td>
                    <?php $new_ctr = count($goals_concerns)+1; ?>
                    <?php echo $form->hiddenField($model, '['. $new_ctr .']id', array('class'=>'concernAdd')); ?>
                    <?php echo $form->dropDownList($model, '['. $new_ctr .']action_type', array('Goal'=>'Goal', 'Concern'=>'Concern'), array('class'=>'concernAdd')); ?>
                </td>
                <td>
                    <?php echo $form->textField($model, '['. $new_ctr .']action_description', array('class'=>'text-control concernAdd', 'placeholder'=>'Description')); ?>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <button id="btn-add-goals-concerns" type="button" class="btn btn-warning">Save Item</button>
                </td>
            </tr>
            <?php $this->endWidget(); ?>
        </tbody>
    </table>
</div>

<script>
    function add_action_item(e) 
    {
        e.preventDefault;
        debugger;
        var param = $('.concernAdd').serialize(); //$('#goals-concerns-form').serialize();
        $.post(global_config.base_url + '/dialog/goals_concerns', param, function(data) {
            if(data.status=='success') {
                msgbox('success', data.json);
                dialogbox('Action Items', '/dialog/goals_concerns', 'hide');
                location.reload();
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
            $('#btn-add-goals-concerns').on('click', add_action_item);
            var label = $('.page-sub-label').text()
            $('#action_type').val(label);
            
            // select2
            $('select').select2();
            
            // edited and update
            $('.cLfocus').on('change', function(e) {
                e.preventDefault;
                $(this).addClass('edited');
            });
            $('.cLfocus').on('focusout', function(e) {
                e.preventDefault;
                if ($(this).hasClass('edited')) {
                    var id = $(this).attr('data-id');
                    var param = $('[name^="GoalsConcern"][data-id="'+ id +'"]').serialize();
                    $.post(global_config.base_url + '/dialog/goals_concerns', param, function(data) {
                        if(data.status=='success') {
                            msgbox('success', data.json);
                            dialogbox('Action Items', '/dialog/goals_concerns', 'hide');
                        } else {
                            alert(data.description);
                        }
                    });
                }
            });
        });
    })();
    </script>