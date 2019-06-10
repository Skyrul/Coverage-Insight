<style>
.page-div {
    padding: 4px;
    margin-bottom: 4px;
    display: block;
    border: 1px solid #d0cece;
    background-color: #f9f8f8;
    cursor: pointer;
}
.row {
    width: 48% !important;
}
.subpage-div {
    padding: 4px;
    margin-bottom: 4px;
    margin-left: 20px;
    display: block;
    border: 1px solid #d0cece;
    background-color: #f8f8f959;
}
</style>
<div class="row">
<?php 
    // INLINE FUNCTION
    function visible_checked($permitted, $program_code) 
    {
        foreach($permitted as $k=>$v) {
            if ($v->program_code == $program_code) {
                if ($v->visible == 'on') {
                    return true;
                    break;
                }
            }
        }
        return false;
    }

    function enable_checked($permitted, $program_code) 
    {
        foreach($permitted as $k=>$v) {
            if ($v->program_code == $program_code) {
                if ($v->enable == 'on') {
                    return true;
                    break;
                }
            }
        }
        return false;
    }
    
    function inline_row_html($permitted, $program_code)
    {   
        $visible = (visible_checked($permitted, $program_code)) ? 'checked' : '';
        $enable  = (enable_checked($permitted, $program_code)) ? 'checked' : '';


        $checkbox  = '<span class="pull-right">';
        //$checkbox .= '<label style="font-size:11px;color:skyblue;font-weight: normal;">Enable</label> <input type="checkbox" name="Permission[enable]['.$program_code.']" '.$enable.' />&nbsp;&nbsp;';
        $checkbox .= '<label style="font-size:11px;color:skyblue;font-weight: normal;">Visible</label> <input type="checkbox" data-id="'.$program_code.'" name="Permission[visible]['.$program_code.']" '.$visible.' />';
        $checkbox .= '</span>';
        return $checkbox;
    }

    // Form
    $form= $this->beginWidget('CActiveForm', array(
        'id'=>'permission-form',
        'focus'=>array($model, 'group_name')
    ));    
    
    echo '<input type="hidden" name="Permission[security_group_id]" value="'. $sec_id .'" />';
    
	$features = ProgramFeatures::model()->findAll("feature_type='page'");
	foreach($features as $k=>$v):
	
	
    	// dropdown
    	$dropdown = '<i class="fa fa-plus fa-2x drop-down" data-id="'. $v->program_code .'"></i>&nbsp;';
	
	   // feature type
	   $feature_type = '&nbsp;<span>('. $v->feature_type .')</span>';
	   
	   // write parent page
	   echo '<div class="page-div">'. $dropdown . $v->description . $feature_type . inline_row_html($permitted, $v->program_code) . '</div>';
	
	   
	   echo '<div id="wp'. $v->program_code .'" style="display:none;">'; //begin subpage wrapper
	   
	   // get section feature
	   $sub = ProgramFeatures::model()->findAll("feature_type='section' AND parent_id = '". $v->program_code ."'");
	   if (!empty($sub)):
	       foreach($sub as $sk=>$sv):
	          $feat1 = '&nbsp;<span>('. $sv->feature_type .')</span>';
	          echo '<div class="subpage-div">'. $sv->description . $feat1 . inline_row_html($permitted, $sv->program_code) .'</div>';
	       endforeach;
	   endif;
	   
	   // get sub feature
	   $sub2 = ProgramFeatures::model()->findAll("feature_type IN ('button', 'gotomenu') AND parent_id = '". $v->program_code ."'");
	   if (!empty($sub2)):
	       foreach($sub2 as $sk=>$sv):
	          $feat2 = '&nbsp;<span>('. $sv->feature_type .')</span>';
	          echo '<div class="subpage-div">'. $sv->description . $feat2 . inline_row_html($permitted, $sv->program_code) .'</div>';
    	   endforeach;
	   endif;
	   
	   echo '</div>'; //end wrapper
	   
	endforeach;
	?>
    
    <center>
        <button id="btn-save" type="button" class="btn btn-warning">Save</button>
    </center>
   
    
    <?php $this->endWidget(); ?>
</div>

<script>
    function saverecord(e) 
    {
        e.preventDefault;
        var param = $('#permission-form').serialize();
        debugger;
        $.post(global_config.base_url + '/permission/save', param, function(data) {
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


            // dropdown
            $('.drop-down').on('click', function(e) {
                e.preventDefault();
                var code = $(this).attr('data-id');
                $('#wp'+code).toggle();
                if ($(this).hasClass('fa-plus')) {
                    $(this).removeClass('fa-plus');
                    $(this).addClass('fa-minus');
                }
                else if ($(this).hasClass('fa-minus')) {
                    $(this).removeClass('fa-minus');
                    $(this).addClass('fa-plus');
                }
            });

            // trigger when clicked
            $('input[name^="Permission"][type="checkbox"]').click(function() {
            	var is_checked = $(this).is(':checked');
				var id = $(this).attr('data-id');
				var checkboxes = $('#wp'+ id).find('input[type="checkbox"]');
				checkboxes.prop('checked', is_checked);
            });
            
        });
    })();
    </script>