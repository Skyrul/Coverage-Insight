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
        'id'=>'staff-form',
        'focus'=>array($model, 'fullname')
    ));
    ?>    
    <table class="col-md-6">
    		<tr>
    			<td colspan="4">
        			<div class="row text-left">
        				<b style="color:red;">*</b> Fill-up required fields&nbsp;&nbsp;
        			</div>
    			</td>
    		</tr>
    		<tr>
    			<td colspan="2"><span class="errorMessage"></span></td>
    		</tr>
    		<?php echo $form->hiddenField($model, 'id'); ?>
            <tr>
            	<td>Staff Name: *</td>
                <td>
                    <?php echo $form->textField($model, 'fullname', array('class'=>'text-control', 'placeholder'=>'Full Name')); ?>
                </td>
            </tr>
            <tr>
            	<td>Email: *</td>
                <td>
                    <?php echo $form->textField($model, 'email', array('class'=>'text-control', 'placeholder'=>'Email')); ?>
                </td>
            </tr>
            <tr>
            	<td>Position:</td>
                <td>
                    <?php echo $form->textField($model, 'position', array('class'=>'text-control', 'placeholder'=>'Position')); ?>
                </td>
            </tr>
            <tr>
            	<td>Phone:</td>
                <td>
                    <?php echo $form->textField($model, 'phone', array('class'=>'text-control dt-picker', 'placeholder'=>'Phone')); ?>
                </td>
            </tr>
            <tr>
            	<td>Mobile:</td>
                <td>
                    <?php echo $form->textField($model, 'mobile', array('class'=>'text-control', 'placeholder'=>'Mobile')); ?>
                </td>
            </tr>
            <tr>
            	<td>Security Group:</td>
                <td>
                	<?php echo $form->dropDownList($model, 'security_group_id', CHtml::listData($security_group, 'id', 'group_name'), array('empty'=>'(select)', 'class'=>'text-control')); ?>
                </td>
            </tr>
            <tr>
            	<td>Status:</td>
            	<td>
            		<?php echo $form->dropDownList($model, 'status', array('inactive'=>'Inactive', 'active'=>'Active'), array('empty'=>'Select', 'class'=>'text-control')); ?>
            	</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="4">
                <center>
                    <button id="btn-save" type="button" class="btn btn-warning">Save</button>
                </center>
                </td>
            </tr>
        </tfoot>
    </table>
   
    
    <?php $this->endWidget(); ?>
</div>

<script>
    function saverecord(e) 
    {
        e.preventDefault;
        debugger;
        var param = $('#staff-form').serialize();
        $.post(global_config.base_url + '/staff/update', param, function(data) {
            if(data.status=='success') {
                msgbox('success', data.json);
                dialogbox('', '', 'hide');
            } else {
            	$('.errorMessage').html(data.json);
            }
        });
    }
    function close_dialog() 
    {
        $(global_config.dlg).modal('hide')
    }
    
    !(function() {
        $(document).ready(function() {
            $('#btn-save').on('click', saverecord);
            $('.dtpicker').datepicker();
        });
    })();
    </script>