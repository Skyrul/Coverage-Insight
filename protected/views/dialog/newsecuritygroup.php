<div class="row">   
    <?php
    $form= $this->beginWidget('CActiveForm', array(
        'id'=>'securitygroup-form',
        'focus'=>array($model, 'group_name')
    ));
    ?>    
    <table class="col-md-6">
    	<tbody>
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
            	<td>Security Group Name: *</td>
                <td>
                    <?php echo $form->textField($model, 'group_name', array('class'=>'text-control', 'placeholder'=>'Full Name')); ?>
                </td>
            </tr>
            <tr>
            	<td>Status: *</td>
                <td>
                    <?php echo $form->dropDownList($model, 'status', array(EnumStatus::ACTIVE=>'Active', EnumStatus::INACTIVE=>'Inactive'), array('class'=>'text-control')); ?>
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
        var param = $('#securitygroup-form').serialize();
        $.post(global_config.base_url + '/securitygroup/save', param, function(data) {
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