form_autosave = function (keyCode)
{
    if (keyCode === 13) {
        
        var data = $('#customer-form').serialize();

        $.ajax({
            type: 'POST',
            url: global_config.base_url + '/api/customer_save',
            data: data,
            success: function (data) {
                if (data.status === 'success') {
                    msgbox('success', 'Successfully saved!')
                    setTimeout(function () {
                        location.href = global_config.current_url;
                    }, global_config.timer_delay - 300);

                } else if (data.status === 'error') {
                    var i = 0;
                    var frm = '#Customer_';
                    $.each(data.json, function (k, v) {
                        // console.log(k, v);
                        // Only focus on the first element that have error
                        i++;
                        if (i > 0) {
                            $(frm + k).attr('title', v);
                            $(frm + k).tooltip('show');
                            $(frm + k).focus();
                            setTimeout(function () {
                                $(frm + k).tooltip('destroy');
                            }, global_config.timer_delay);
                        }
                    });
                }
            },
            error: function (data) {
                console.log(data.responseText);
                msgbox('error', 'Error on your request');
            },
        });
        return false;
    }
}

valid_keycode = function(keycode)
{
    var valid =
    	(keycode === 9)  ||
    	(keycode === 13) || // spacebar & return key(s) (if you want to allow carriage returns)
        (keycode > 47 && keycode < 58)   || // number keys
        (keycode > 64 && keycode < 91)   || // letter keys
        (keycode > 95 && keycode < 112)  || // numpad keys
        (keycode > 185 && keycode < 193) || // ;=,-./` (in order)
        (keycode > 218 && keycode < 223);   // [\]' (in order)

    return valid;	
}

submit_form = function()
{
	var param = $('.editbox').serialize();
	param += '&Customer[Id]=' + $('.editbox:eq(0)').attr('data-keyid');
	$.post(global_config.base_url + '/customer/update', param, function(data) {
		if (data.status === 'success') {
			msgbox(data.status, data.json);
			setTimeout(function() { location.reload(); }, 800);
			return;
		}
		msgbox('error', 'Error on your update request');
	});	
}

edit_submit = function(e) 
{
	if (valid_keycode(e.keyCode)) {
		$(this).addClass('edited');
		if (e.keyCode === 13) {
			submit_form();
		}
	}
}

focusout_submit = function()
{
	if ($(this).hasClass('edited')) {
		submit_form();
	}	
}

open_browse_file = function()
{
	$('#file_import').trigger('click');
	$('#btn-import').show();
	$('#btn-browse-file').hide();
}

open_file_upload = function()
{
	alertify.confirm("Are you sure to upload this file?<br><br>Reminder: This will auto append to our existing records", 
	function() {
	   $('#frm-upload').submit();
	}, 
	function() {
	   alert('Action cancelled');
	   location.reload();
	});
}

/* Events */
$(document).ready(function () {
    app.datagrid = $('.datagrid').DataTable({
        'order': [],
        'columnDefs': [{
                targets: [0, 1, 2, 3, 4],
                orderable: false
            }],
        'dom': 'tp',
        'scrollY': "100%",
        'scrollCollapse': true,
        'paging': false,
    });

    // initialize sort and filter
    app.filter_limit = 3;  // override: number of columns only alowed to have filter
    sort_filter_init($('.datagrid thead th'));

    // Inline editing
    app.selected_row = 0;     // init temporary storage
    app.selected_values = [];
    app.edit_limit = [0,1];   // only allow column for editing
    $('tr').on('click', function(e) {
    	var row = $(this);
    	if (app.selected_row === 0) {
    		// Store selected row
    		app.selected_row  =  row.attr('data-keyid');
    	} else {
    		// If new clicked row is the same row no edit mode
    		if (app.selected_row === row.attr('data-keyid')) {
    			return false;
    		}
    		// Restore previous clicked row
    		var prev_row = $('tr[data-keyid="'+ app.selected_row +'"]');
        	$('td', prev_row).each(function(k, v) {
        		if (isInArray(parseInt(k), app.edit_limit)) {
        			$(v).empty();
        			$(v).html(app.selected_values[k]);
        		}
        	});
        	
    		// Change selected row
    		app.selected_row  =  row.attr('data-keyid');
    	}
    	
    	// Add control
    	$('td', row).each(function(k, v) {
    		if (isInArray(parseInt(k), app.edit_limit)) {
    			app.selected_values[k] = $(v).text();  // Store data of current selected
    			$(v).html('<input name="Customer[data'+ k +']" data-keyid="'+ app.selected_row +'" value="'+ $(v).text() +'" class="editbox form-control" type="text">');
    			$(v).find('input[data-keyid="'+ app.selected_row +'"]').bind('keyup', edit_submit);
    			$(v).find('input[data-keyid="'+ app.selected_row +'"]').bind('focusout', focusout_submit);
    		}
    	});
    	
    	// Focus on first input
    	$('input[type="text"]:eq(0)').focus();
    });
    
    $('#btn-addgrid').on('click', function (e) {
        var me = $(this).prop('disabled');
        $(this).prop('disabled', !me);

        $('table#DataTables_Table_0').css('margin-top', '0');
        app.datagrid.row.add(app.input_fields).draw(false);

        var $scrollBody = $(app.datagrid.table().node()).parent();
        $scrollBody.scrollTop($scrollBody.get(0).scrollHeight);

        // focus on first field
        $('input[type="text"]').first().focus();
    });

    $('.btn-deletegrid').on('click', function (e) {
        e.preventDefault;

        var id = $(this).attr('data-id');
        alertify.confirm("Are you sure to delete this record?", function () {
            location.href = global_config.base_url + "/customer/delete?id=" + id;
        });
    });

});
