function rewrite_policies_form()
{
	app.policies = null;
	$.post(global_config.base_url + '/api/policies_all', function(json) {
		var data = JSON.parse(json);
		if (data.length !== 0) {
		    for (i = 0; i < app.insurance_types.length; i++)
		    {
		        var insurance_type = app.insurance_types[i];
		        $('#tbl-' + insurance_type).find('tbody').empty();
		    }
		    
		    // for display
		    app.policies = json;
		    policies_form();
		}
	});

}

function order_up(t)
{
    var data_type = $(t).attr('data-type');
    var param = {
    	'Account':{ 'id':$(t).attr('data-rec'), 'type': data_type,  'direction':'up' }
    };
    $.post(global_config.base_url + '/api/policy_order?direction=up', param, function(data) {
        console.log(data);
        return;

    	msgbox(data.status, data.json);
    	if (data.status == 'error') { return; }    		
    	setTimeout(function() {
    		rewrite_policies_form();
    	}, 800);
    });
}

function order_down(t)
{
    var param = {
        'Account':{ 'id':$(t).attr('data-rec'), 'type': $(t).attr('data-type'),  'direction':'down' }
    };
    $.post(global_config.base_url + '/api/policy_order', param, function(data) {
    	msgbox(data.status, data.json);
    	if (data.status == 'error') { return; }    		
    	setTimeout(function() {
    		rewrite_policies_form();
    	}, 800);
    });
}

function button_show_and_hide(that)
{
    var id = $(that).attr('data-id');
    var typee = $(that).attr('data-type');
    var frm = $('[name^="PoliciesForm[ChildValue_' + typee + '-' + id + '"]');

    $(that).removeClass('fa-plus');
    $(that).removeClass('fa-minus');
    if (frm.is(':visible')) {
        $(that).addClass('fa-plus');
        frm.hide();
    } else {
        $(that).addClass('fa-minus');
        frm.show();
    }
}

function delete_policy(that)
{
    var id = $(that).attr('data-rec');
    var param = {};
    param.id = id;

    if (confirm('Are you sure to delete this item?')) {
        $.post(global_config.base_url + '/setup/delete_policy', param, function (data) {
            if (data.status === "success") {
                location.reload();
            } else {
                msgbox('error', data.json);
            }
        });
    }
}

function submit_insurance(insurance_type) {
    var param = $('#policies-' + insurance_type + '-form').serialize();
    $.post(global_config.base_url + '/setup/update_policies?insurance_type=' + insurance_type, param, function (data) {
        console.log(data);
        if (data.status === 'success') {
            //msgbox('success', data.json);
            alertify.log(data.json);
        } else {
            msgbox('error', data.json);
        }
    });
}

function policies_form()
{
    for (i = 0; i < app.insurance_types.length; i++)
    {
        var insurance_type = app.insurance_types[i];

        // populate existing record
        var row_ = $('#tbl-' + insurance_type);
        var ctr = 0;
        var data = null;

        var data = JSON.parse(app.policies); // this get from setup.php INLINE RENDER DATA
        $.each(data, function (k, v) {
            if (v.policy_parent_label === insurance_type) {
                ctr++;
            }
        });

        if (ctr > 0) {
            data = JSON.parse(app.policies); // this get from setup.php INLINE RENDER DATA
            ctr = 0;
            $.each(data, function (k, v) {
                if (v.policy_parent_label === insurance_type) {
                    ctr++;
                    row_.find('tbody').append(policy_row(v, ctr));
                }
            });
            $('#' + insurance_type + '-count').val(ctr)
        } else {
            var param = {};
            param.policy_parent_label = insurance_type;
            param.is_child_checked = "1";
            row_.find('tbody').append(policy_row(param, 1));
        }
    } // For..looop

    policies_event();
}

function policies_event()
{
    for (i = 0; i < app.insurance_types.length; i++)
    {
        var insurance_type = app.insurance_types[i];
        // attached event
        $('form#policies-' + insurance_type + '-form').find('input').on('keypress', function (e) {
            if (e.keyCode === 13) {
                var insurance_type = $(this).attr('data-type');
                submit_insurance(insurance_type);
                return false;
            }
        });
        $('form#policies-' + insurance_type + '-form').find('input').on('focusout blur', function (e) {
            var insurance_type = $(this).attr('data-type');
            submit_insurance(insurance_type);
            return false;
        });
        $('form#policies-' + insurance_type + '-form').find('input[type="checkbox"]').on('click', function (e) {
            e.preventDefault;
            var insurance_type = $(this).attr('data-type');
            submit_insurance(insurance_type);
        });
    } // For...Loop
}

function policy_row(row, count)
{
    var sb = new StringBuilder();
    var fixed_policy = [ 'Year', 'Make', 'Model'];
    var plus_event = 'onclick="button_show_and_hide(this)"';
    var delete_event = 'onclick="delete_policy(this)"';
    var input_event = '';
    if (fixed_policy.indexOf(row.policy_child_label) > -1) {
        plus_event = 'onclick="alert(\'Sorry this field cannot be changed, it was reserved for this program\')";';
        delete_event = 'disabled="true" style="background-color:lightgray;"';
        input_event = 'readonly="true"';
    }
    sb.clear();
    sb.append("<tr id='tr_policy-" + count + "'>");
    sb.append("<td>&nbsp;</td>");
    sb.append("<td>");
    sb.append(' <div class="col-xs-1">');
    sb.append('   <input name="PoliciesForm[ChildChk_' + row.policy_parent_label + '-' + count + ']" data-type="' + row.policy_parent_label + '" type="checkbox" class="setup-checkbox pull-right form-control" ' + ((row.is_child_checked === "1") ? "checked" : "") + ' />');
    sb.append(' </div>');
    sb.append(' <div class="col-xs-7">');
    sb.append('   <div class="col-xs-12">');
    sb.append('      <div class="input-group">');
    sb.append('         <input '+ input_event +' name="PoliciesForm[ChildText_' + row.policy_parent_label + '-' + count + ']" data-type="' + row.policy_parent_label + '" type="text" class="form-control" value="' + ((typeof row.policy_child_label === "undefined") ? '' : row.policy_child_label) + '" />');
    sb.append('         <span class="input-group-btn">');
    sb.append('              <button type="button" '+ delete_event +' data-type="' + row.policy_parent_label + '" data-id="' + count + '" data-rec="' + row.id + '" class="btn btn-default btn-sm"><i class="fa fa-close"></i></button>');
    sb.append('         </span>');
    sb.append('         <span class="input-group-btn">');
    sb.append('              <button onclick="order_up(this)" type="button" data-type="' + row.policy_parent_label + '" data-id="' + count + '" data-rec="' + row.id + '" class="btn btn-default btn-sm"><i class="fa fa-caret-up"></i></button>');
    sb.append('              <button onclick="order_down(this)" type="button" data-type="' + row.policy_parent_label + '" data-id="' + count + '" data-rec="' + row.id + '" class="btn btn-default btn-sm"><i class="fa fa-caret-down"></i></button>');
    sb.append('         </span>');
    sb.append('       </div>');
    sb.append('   </div>');
    sb.append(' </div>');
    sb.append(' <div class="col-xs-1">');
    sb.append('   <i class="fa fa-plus fa-2x" '+ plus_event +' data-type="' + row.policy_parent_label + '" data-id="' + count + '"></i>');
    sb.append(' </div>');
    sb.append('</td>');
    sb.append('</tr>');
    sb.append('<tr>');
    sb.append('<td colspan="2">');
    sb.append('  <div class="col-xs-offset-2 col-xs-8">');
    sb.append('    <input name="PoliciesForm[ChildValue_' + row.policy_parent_label + '-' + count + ']" data-type="' + row.policy_parent_label + '" type="text" class="pull-left form-control hide-el" value="' + ((typeof row.policy_child_values === "undefined") ? '' : row.policy_child_values) + '" />');
    sb.append('  </div>');
    sb.append('</td>');
    sb.append('</tr>');
    return sb.toString();
}

function check_email_status()
{
    app.ei = $('#email-indicator-text')
    app.ei.text('Checking Email Status..');
    app.ei.css('color', 'gray');
    $.post(global_config.base_url + '/tests/emailstatus', function(data) {
    	store.set('indicator_email', data.status);    	
    	app.ei.empty();
    	if (data.status === true) {
    		app.ei.text('Connected.');
    		app.ei.after('<span>You can send email outside</span>');
    		app.ei.css('color', 'green');
    	} else {
    		app.ei.text('Not Connected.');
    		app.ei.after('<span>Cannot connect to your Email Server</span>');
    		app.ei.css('color', 'red');
    	}
    });
}

(function () {
	var frms = 'form#info-form, form#email-form, form#listing-form, form#colour-form';
    $(frms).find('input').on('keyup', function (e) {
    	// debugger;
    	if (typeof e.keyCode === 'undefined') {
    		return;
    	}
    	if (e.keyCode !== 9) {
        	$(this).addClass('edited');	
    	}
    });

    $(frms).find('input').on('focusout', function (e) {
    	// debugger;
    	if ($(this).hasClass('edited')) {
    		var param = $(e.target.form).serialize();
    		$.post(e.target.form.action, param, function(data) {
    			msgbox(data.status, data.json);
    		});
    	}
    });
    
    $(frms).find('input').on('keypress', function (e) {
    	// debugger;
        if (e.keyCode === 13) {
    		var param = $(e.target.form).serialize();
    		$.post(e.target.form.action, param, function(data) {
    			msgbox(data.status, data.json);
    		});
        }
    });

    $(frms + ' select').on('select2:select', function (e) {
    	// debugger;
		var param = $(e.target.form).serialize();
		$.post(e.target.form.action, param, function(data) {
            if (typeof data.status != "undefined") {
                msgbox(data.status, data.json);
            }
			
			// which object was change
			if (e.currentTarget.id.indexOf('ColourForm_colour_scheme_id') > -1) {
				location.href=global_config.base_url + '/account/setup?t='+ Math.random() + '#colour'
			}
		});
    });

    $('form#password-form').on('submit', function (e) {
    	// debugger;
        e.preventDefault;
        var pass1 = $('#PasswordForm_password').val();
        var pass2 = $('#PasswordForm_repeat_password').val()
        var res = (pass1 !== pass2);
        if (res) {
        	alertify.error('The new password entered does not match?');
        }

        return !res;
    });

    $(".colour-box").spectrum({
        showInput: true,
        showInitial: true,
        showPalette: true,
        showSelectionPalette: true,
        maxSelectionSize: 10,
        preferredFormat: "hex",
        localStorageKey: "accountsetup.colours",
        color: 'blanchedalmond',
        palette: [
            ["#000", "#444", "#666", "#999", "#ccc", "#eee", "#f3f3f3", "#fff"],
            ["#f00", "#f90", "#ff0", "#0f0", "#0ff", "#00f", "#90f", "#f0f"],
            ["#f4cccc", "#fce5cd", "#fff2cc", "#d9ead3", "#d0e0e3", "#cfe2f3", "#d9d2e9", "#ead1dc"],
            ["#ea9999", "#f9cb9c", "#ffe599", "#b6d7a8", "#a2c4c9", "#9fc5e8", "#b4a7d6", "#d5a6bd"],
            ["#e06666", "#f6b26b", "#ffd966", "#93c47d", "#76a5af", "#6fa8dc", "#8e7cc3", "#c27ba0"],
            ["#c00", "#e69138", "#f1c232", "#6aa84f", "#45818e", "#3d85c6", "#674ea7", "#a64d79"],
            ["#900", "#b45f06", "#bf9000", "#38761d", "#134f5c", "#0b5394", "#351c75", "#741b47"],
            ["#600", "#783f04", "#7f6000", "#274e13", "#0c343d", "#073763", "#20124d", "#4c1130"]
        ],
        allowEmpty: true,
        chooseText: "Select",
        cancelText: "Cancel",
        hide: function (color) {
            if ($('#ColourForm_colour_scheme_id option:selected').text() !== "Custom") {
            	// Set to Custom
            	$('#ColourForm_colour_scheme_id').select2("val", $("#ColourForm_colour_scheme_id option:contains('Custom')").val());
            	$('#hidden_colour_scheme_id').val($('#ColourForm_colour_scheme_id').val());
            }
            var id = $(this).attr('id');
            $(this).css('background-color', color);
            $('input[name="CustomColor[' + id + ']"]').val(color);
            var param = $('#colour-form').serialize();
            $.post(global_config.base_url + '/setup/updatecustom_colour', param, function (data) {
                if (data.status === 'success') {
                    msgbox('success', data.json);
                    setTimeout(function () {
                        location.reload();
                    }, 900);
                }
            });
        }
    });


    // Lists of insurance types
    app.insurance_types = [
        "Auto",
        "Home",
        "Life",
        "Personal_Liability",
        "Disability",
        "Health",
        "Other",
        "Commercial"
    ];


    policies_form();

    for (i = 0; i < app.insurance_types.length; i++) {
        var insurance_type = app.insurance_types[i];
        $("#btn-" + insurance_type).on('click', function (e) {
            var a = $(this).attr('id');
            a = a.split('-');
            var insurance_type = a[1];
            var count = parseInt($('#' + insurance_type + '-count').val());
            if (count <= 9) {
                count++;
                $('#' + insurance_type + '-count').val(count);
                var row_data = {};
                row_data.policy_parent_label = insurance_type;
                row_data.is_child_checked = "1";
                $('#tbl-' + insurance_type).find('tbody').append(policy_row(row_data, count));
                policies_event();
            } else {
                msgbox('error', 'Only 10 policies allowed');
            }
        });
    }

    function change_smtp_type(smtp_type) {
        $('#EmailForm_smtp_type').val(smtp_type);
        $('[id^="EmailForm"]').show();
        $('[id^="EmailForm"]').prop('disabled', false);
        $('#btn-gmail').hide();
        switch (smtp_type) {
            case "":
            case "system":
                $('[data-form="email"]').hide();
                break;
            case "custom":
                $('[data-form="email"]').show();
                break;
            case "gmail":
                $('[data-form="email"]').show();

                $('#EmailForm_smtp_server').val('smtp.gmail.com');
                $('#EmailForm_smtp_port').val('587');

                $('#EmailForm_smtp_server').on('keypress', function() { return false; });
                $('#EmailForm_smtp_port').on('keypress', function() { return false; });

                $('#btn-gmail').show();
                break;
        }
    }

    // Swapping form display of Email
    $('#checkbox_type').on('click change', function (e) {
        e.preventDefault();
        var smtp_type = $(this).find(':selected').val();
        change_smtp_type(smtp_type);
    });

    // Select option after load
    var mail_type = $('#EmailForm_smtp_type');
    var smtp_type = (mail_type.val() === "") ? 'system' : mail_type.val();
    $('#checkbox_type').val(smtp_type).trigger('change.select2')
    change_smtp_type(smtp_type);

    // Testing email settings
    $('#btn-testemail').on('click', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        location.href=url;
    });
    
    
    // Check status of email
    $('#email-indicator').on('click', function() {
    	check_email_status();
    });
    setTimeout(function() {
    	check_email_status();
    }, 2000);
    
    // Resource Check Usage
    var request = new XMLHttpRequest;
    request.open('GET', app.cl_api_endpoint, true);
    request.onload = function() {
    	if (this.status === 200) {
    		var result = JSON.parse(this.response);
    	}
    };
    request.send();
    
    // Resource Upload
    $('.btn-resource-upload').on('click', function(e) {
    	e.preventDefault();
    	var itype = $(this).attr('data-itype');
    	var url = global_config.base_url + '/account/resource_upload?itype='+itype;
    	app.insurance_type = itype;
    	app.action = 'policies';
    	dialogbox('Resource Upload - ' + itype, url, 'show');
    });
    
    // Resource Browse
    $('#btn-browse-file').on('click', function() {
    	var cl = new cloudinary.Cloudinary({cloud_name: app.cl_cloud_name, secure: true});
		cloudinary.openUploadWidget({ cloud_name: app.cl_cloud_name, upload_preset: app.cl_client_docs_preset }, function(error, result) {
					console.log(error, result);
					if (error == null) {
						var param = { 'json': JSON.stringify(result[0]) };
						$.post(global_config.base_url + '/setup/update_resource?insurance_type='+app.insurance_type, param, function(data) {
							msgbox(data.status, data.json);
							if (data.status === 'success') {
								location.href=global_config.base_url + '/account/setup?t='+ Math.random() +"#policies";
							}
						});
					}
		});
    });
    
    // Resource Delete
    $('.btn-delete-resource').on('click', function(e) {
    	e.preventDefault();
    	var id = $(this).attr('data-id');
    	if (confirm("Are you sure to delete this item?\n\n Note: Once deleted this cannot be rollback")) {
			$.post(global_config.base_url + '/setup/remove_resource?id='+id, '', function(data) {
				debugger;
				msgbox(data.status, data.json);
				if (data.status === 'success') {
					location.href=global_config.base_url + '/account/setup?t='+ Math.random()  +"#policies";
				}
			});
    	}
    });
    
    // Resource Custom Label
    $('.resource_custom_label').on('keyup', function(e) {
    	if (e.keyCode === 9) {
    		return;
    	}
    	$(this).addClass('edited');
    });
    $('.resource_custom_label').on('focusout', function(e) {
    	if ($(this).hasClass('edited')) {
    		var id = $(this).attr('data-id');
    		var param = $(this).serialize();
			$.post(global_config.base_url + '/setup/update_resource_custom_label?id='+id, param, function(data) {
				msgbox(data.status, data.json);
			});
    	}
    });
    
    // Upload Company Logo
    $('#btn-upload-image').on('click', function() {
    	var cl = new cloudinary.Cloudinary({cloud_name: app.cl_cloud_name, secure: true});
		cloudinary.openUploadWidget({ cloud_name: app.cl_cloud_name, upload_preset: app.cl_upload_preset }, function(error, result) {
					console.log(error, result);
					if (error == null) {
						var param = { 'json': JSON.stringify(result[0]) };
						$.post(global_config.base_url + '/setup/update_logo', param, function(data) {
							debugger;
							msgbox(data.status, data.json);
							if (data.status === 'success') {
								location.reload();
							}
						});
					}
		});
    });
    
    // Add new Staff
    $('.btn-new-staff').on('click', function(e) {
    	e.preventDefault();
    	app.action = 'staff';
    	var url = global_config.base_url + '/dialog/newstaff';
    	dialogbox('New Staff Information', url, 'show');
    });
    
    // Edit Existing Staff
    $('.btn-edit-staff').on('click', function(e) {
    	e.preventDefault();
    	app.action = 'staff';
    	var id = $(this).attr('data-id');
    	var fullname = $(this).attr('data-fullname');
    	var url = global_config.base_url + '/dialog/editstaff/'+id;    	
    	dialogbox('Update Staff Information (' + fullname + ')', url, 'show');
    });

    // Delete Existing Staff
    $('.btn-delete-staff').on('click', function(e) {
    	e.preventDefault();
    	app.action = 'staff';
    	var id = $(this).attr('data-id');
    	var fullname = $(this).attr('data-fullname');
    	var url = global_config.base_url + '/staff/delete?id='+id;    	
    	alertify.confirm('Are You Sure Delete Staff: '+ fullname +'?', 
		function() {
		   $.post(url,function(data) {
			   alertify.alert(data.json);
			   app.closeAction();
		   });
		}, 
		function() {
		});
    });
    
    // Re-Send Staff Verification
    $('.btn-send-staff-verification').on('click', function(e) {
    	e.preventDefault();
    	app.action = 'staff';
    	var id = $(this).attr('data-id');
    	var fullname = $(this).attr('data-fullname');
    	var url = global_config.base_url + '/staff/resend_verification?id='+id;
    	$(this).addClass('btn-warning');
    	$(this).text('Re-sending Please Wait....');
    	$.get(url,'', function(data){
    		alertify.alert(data.json);
    		setTimeout(function() {
    			app.closeAction();
    		},800);
    	});
    });
    

    // New Security Group
    $('.btn-new-security-group').on('click', function(e) {
    	e.preventDefault();
    	app.action = 'security-group';
    	var url = global_config.base_url + '/dialog/newsecuritygroup';    	
    	dialogbox('New Security Group', url, 'show');
    });
    
    // Edit Security Group
    $('.btn-edit-security-group').on('click', function(e) {
    	e.preventDefault();
    	app.action = 'security-group';
    	var id = $(this).attr('data-id');
    	var fullname = $(this).attr('data-fullname');
    	var url = global_config.base_url + '/dialog/editsecuritygroup/'+ id;    	
    	dialogbox('Update Security Group ('+ fullname +')', url, 'show');
    });
    
    // Set Permission
    $('.btn-set-permission-group').on('click', function(e) {
    	e.preventDefault();
    	debugger;
    	app.action = 'security-group';
    	var id = $(this).attr('data-id');
    	var fullname = $(this).attr('data-fullname');
    	var url = global_config.base_url + '/dialog/setpermission?id='+ id;    	
    	dialogbox('Set Permission ('+ fullname +')', url, 'show');
    });
    
    // Delete Existing Security Group
    $('.btn-delete-security-group').on('click', function(e) {
    	e.preventDefault();
    	app.action = 'security-group';
    	var id = $(this).attr('data-id');
    	var fullname = $(this).attr('data-fullname');
    	var url = global_config.base_url + '/securitygroup/delete?id='+id;    	
    	alertify.confirm('Are You Sure Delete Group '+ fullname +'?', 
		function() {
		   $.post(url,function(data) {
			   alertify.alert(data.json);
			   app.closeAction();
		   });
		}, 
		function() {
		});
    });
    
    // Credit Card Settings Dialog
    $('.btn-credit-card-settings').on('click', function(e) {
    	e.preventDefault();
    	app.action = 'billing';
    	var id = $(this).attr('data-id');
    	var url = global_config.base_url + '/dialog/creditcardsettings';    	
    	dialogbox('Credit Card Setting', url, 'show');
    });
    
    
    // Process Card
    $('.btn-billing-process-card').on('click', function(e) {
    	e.preventDefault();
    	alertify.confirm('Are you sure to process this card?', 
    	function() {
    		$('#billing-form').submit();
    	},
    	function() {	
    	});
    });
    
    // Download Invoice
    $('.btn-download-invoice').on('click', function(e) {
    	e.preventDefault();
    	app.action = 'billing';
    	var bill_no = $('#BillingForm_invoice_no').val();
    	var url = global_config.base_url + '/reports/renderpdf?report_name=billing&report_tpl=billing&billno='+bill_no;    	
    	showReport(url);
    });
    
    
    // New Email Template
    $('.btn-add-email-template').on('click', function(e) {
    	e.preventDefault();
    	app.action = 'email-template';
    	var id = $(this).attr('data-id');
    	var url = global_config.base_url + '/dialog/newemail_template';    	
    	dialogbox('Add Email Template', url, 'show');
    });
    
    // Delete Existing Email Template
    $('.btn-delete-email-template').on('click', function(e) {
    	e.preventDefault();
    	app.action = 'email-template';
    	var id = $(this).attr('data-id');
    	var url = global_config.base_url + '/emailtemplate/delete?id='+id;    	
    	alertify.confirm('Are You Sure Delete Email Template?', 
		function() {
		   $.post(url,function(data) {
			   alertify.alert(data.json);
			   app.closeAction();
		   });
		}, 
		function() {
		});
    });

    // Edit Existing Email Template
    $('.btn-edit-email-template').on('click', function(e) {
    	e.preventDefault();
    	app.action = 'email-template';
    	var id = $(this).attr('data-id');
        var url = global_config.base_url + '/dialog/editemail_template?id='+id;    	
        dialogbox('Update Email Template', url, 'show');
    });

    // Preview Email Template
    $('.btn-preview-email-template').on('click', function(e) {
        e.preventDefault();
        app.action = "email-template";
    	var id = $(this).attr('data-id');
        var url = global_config.base_url + '/emailtemplate/preview?id='+id;
        // popWindow(url, "Preview Email", { w: '500', h: '800' });
        dialogbox('Preview Email', url, 'show');
    });

    // Send Email Template
    $('.btn-send-email-template').on('click', function(e) {
        e.preventDefault();
        var id   = $(this).attr('data-id');
        var code = $(this).attr('data-code');
        alertify.prompt('Enter Email Address of Recipient:', function(data) {
            var url = global_config.base_url + '/emailtemplate/preview?id='+id;
            var urlemail = global_config.base_url + '/emailtemplate/sendtest?id='+id+'&code='+code+'&rcpt='+data;
            $.get(url, function(data) {
                if (data != "") {
                    $.post(urlemail, { 'content': data }, function(result) {
                        if (typeof result.json !== 'undefined') {
                            alert(result.json);
                        } else {
                            alert('Email not sent, Please check your email configuration');
                        }
                    });
                }
            });
        });

    }); 
    
    // When Referral "I agree .." clicked
    $('#GiftCards_i_agree').click(function(e) {
        var a = $('#GiftCards_use_referral');
        if (a.is(':checked')) {
            var param = $('#gift-cards-form').serialize();
            $.post(global_config.base_url + '/giftcards/update', param, function(data) {
                if (data.status == 'success') {
                    location.href = global_config.base_url + '/account/setup?t='+ Math.random() +'#referral';
                }
            });
        } else {
            alert('You must agree first to "Use" Referral function');
        }
    });

    $('#GiftCards_offer_pre_enrollment_credit, #GiftCards_offer_enrollment_credit').click(function(e) {
        var param = $('#gift-cards-form').serialize();
        $.post(global_config.base_url + '/giftcards/update', param, function(data) {
            if (data.status == 'success') {
                location.href = global_config.base_url + '/account/setup?t='+ Math.random() +'#referral';
            }
        });
    });

    $('input[name^="GiftCards"][type="text"]').on('change', function() {
        $(this).addClass('edited');
    });

    $('input[name^="GiftCards"][type="text"]').on('focusout', function() {
        if ($(this).hasClass('edited')) {
            var param = $('#gift-cards-form').serialize();
            $.post(global_config.base_url + '/giftcards/update', param, function(data) {
                if (data.status == 'success') {
                    msgbox(data.status, 'Referrals updated');
                }
            }); 
        }
    });

    
    // Resource Modal Window Close
    app.closeAction = function() {
    	var jump = '#'+ app.action;    	
    	location.href=global_config.base_url + '/account/setup?t='+ Math.random() + jump;    	
    }
    $("#global-modal").on("hidden.bs.modal", function () {
    	app.closeAction();
    });
    
    // Date Picker
    $('.dt-picker').datepicker()
    
    $(document).ajaxStart(function(event, jqxhr, settings) {
    	$('.modal-dialog').before('<div class="xhr-overlay xhr-s xhr-default">Loading Request...</div>');
    });
    
    $( document ).ajaxError(function( event, request, settings ) {
    	$('.xhr-overlay').addClass('xhr-error');
    	$('.xhr-overlay').text('Error on Request');
    	setTimeout(function() {
    		$('.xhr-overlay').remove();
    	}, 800);
    });
    
    $(document).ajaxSuccess(function() {
    	$('.xhr-overlay').addClass('xhr-success');
    	$('.xhr-overlay').text('Done');
    	setTimeout(function() {
    		$('.xhr-overlay').remove();
    	}, 800);
    });
    
})();
