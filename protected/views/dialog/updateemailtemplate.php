<div class="row">   
    <?php
    $form= $this->beginWidget('CActiveForm', array(
        'id'=>'emailtemplate-form',
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
            <?php echo $form->hiddenField($model, 'id'); ?>
    		<tr>
    			<td colspan="2"><span class="errorMessage"></span></td>
    		</tr>
            <tr>
            	<td>Template Name: <b style="color:red;">*</b></td>
                <td>
                    <?php echo $form->hiddenField($model, 'code'); ?>
                    <label><?php echo EnumStatus::emailtemplates()[$model->code]; ?></label>
                </td>
            </tr>
            <tr>
            	<td>From: </td>
                <td>
                    <?php echo $form->textField($model, 'from', array('class'=>'text-control', 'placeholder'=>'(Leave as blank to use system default)')); ?>
                </td>
            </tr>
            
            <!--
            <tr>
            	<td>Bcc: </td>
                <td>
                    <?php echo $form->textField($model, 'bcc', array('class'=>'text-control', 'placeholder'=>'(Leave as blank to use system default)')); ?>
                </td>
            </tr>
            -->

            <tr>
            	<td>Subject: </td>
                <td>
                    <?php echo $form->textField($model, 'subject', array('class'=>'text-control', 'placeholder'=>'(Leave as blank to use system default)')); ?>
                </td>
            </tr>
            <tr>
            	<td>Background Image URL: </td>
                <td>
                    <?php echo $form->textField($model, 'bg_image_url', array('class'=>'text-control', 'placeholder'=>'(Leave as blank if no image)')); ?>
                </td>
            </tr>
            <tr>
            	<td>Layout Style: <b style="color:red;">*</b></td>
                <td>
                    <?php echo $form->dropDownList($model, 'format_type', EnumStatus::emaillayouts(), array('class'=>'text-control')); ?>
                </td>
            </tr>
            <tr>
                <td colspan="10">
                    <h6><strong>Built-in Smart Code: <i class="fa fa-question-circle"></i></strong>&nbsp;<a href="#!" onclick="toggleSmartcode()">[show/hide]</a></h6>
                    <ul id="smartcodehelp" style="display:none;">
                        <li>[application_name]    =  this append web application name</li>
                        <li>[curdate]  = this display current date</li>
                        <li>[user_email]  = this display the current loggedin user email</li>
                        <li>[user_name] = this display the current loggedin user full name</li>
                        <li>[curdatetime] = this display current date/time</li>
                        <li>[agency_logo] = this display agency logo</li>
                    </ul>
                </td>
            </tr>
            <tr>
                <td colspan="10">
                <span class="custom-tags"></span>
                </td>
            </tr>
            <tr valign="top">
            	<td>Head: </td>
            </tr>
            <tr valign="top">
                <td colspan="10">
                    <?php 
                    $attribute = 'html_head';
                    $this->widget('ImperaviRedactorWidget',array(
                        'model'=>$model,
                        'attribute'=>$attribute,
                    ));
                    ?>
                </td>
            </tr>
            <tr valign="top">
            	<td>Body: </td>
            </tr>
            <tr valign="top">
                <td colspan="10">
                    <?php 
                    $attribute = 'html_body';
                    $this->widget('ImperaviRedactorWidget',array(
                        'model'=>$model,
                        'attribute'=>$attribute,
                    ));
                    ?>
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
        e.preventDefault();
        var param = $('#emailtemplate-form').serialize();
        $.post(global_config.base_url + '/emailtemplate/update', param, function(data) {
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
    function toggleSmartcode()
    {
        $('#smartcodehelp').toggle();
    }
    !(function() {
        $(document).ready(function() {
            $('#btn-save').on('click', saverecord);
            $('.dtpicker').datepicker();
            
            var code = $('#EmailTemplate_code').val();
            $.get(global_config.base_url + '/api/templatetags?code='+ code, function(data) {
                $('.custom-tags').html('<strong>Custom Tags:</strong><br> <span style="color: blue;">' + data + '</span><br><br>');
            });
        });
    })();
</script>
