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
            	<td>Username:</td>
                <td>
                    <input type="text" class="text-control" disabled value="You will receive email to set username">
                </td>
            </tr>
            <tr>
            	<td>Password:</td>
                <td>
                    <input type="text" class="text-control" disabled value="You will receive email to set password">
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
        var param = $('#staff-form').serialize();
        $.post(global_config.base_url + '/staff/save', param, function(data) {
        	$('.errorMessage').html(data.json);
            if(data.status=='success') {
                dialogbox('', '', 'hide');
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