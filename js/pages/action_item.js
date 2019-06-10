replace_null = function(str)
{
	return str.replace('null', '');
}
form_autoupdate = function(keyCode, that)
{
	if (keyCode === 13) {
		var row = $(that).attr('row');
		var data = $('#Form_'+ row).find('input, select').serialize();
		app.focus_element = that;

		$.ajax({
			type: 'POST',
			url: global_config.base_url + '/api/actionitem_save',
			data: data,
			success: function(data) {
				console.log(data);
				if (data.status === 'success') {
                                        alertify.success('Updated');
				}
				else if(data.status === 'error') {
					var i=0;

					$.each(data.json, function(k, v) {
						// console.log(k, v);
						// Only focus on the first element that have error
						i++;
						if (i>0) {
							var frm = $('[name^="ActionItem['+ k +'"]');
							frm.focus();
							msgbox('error', v);
						}
					});
				}
			},
			error: function(data) {
				console.log(data.responseText);
				msgbox('error', 'Error on your request');
			},

		});
	}
}

form_autosave = function(keyCode, that)
{
	if (keyCode === 13) {
		var data = $('input[name^="newitem"], select[name^="newitem"]').serialize();
		app.focus_element = that;

		$.ajax({
			type: 'POST',
			url: global_config.base_url + '/api/actionitem_save',
			data: data,
			success: function(data) {
				if (data.status === 'success') {
					msgbox('success', 'Successfully saved!');
					setTimeout(function() {
						location.href=global_config.current_url;
					}, global_config.timer_delay);

				}
				else if(data.status === 'error') {
					var i=0;

					$.each(data.json, function(k, v) {
						// Only focus on the first element that have error
						i++;
						if (i>0) {
							var frm = $('[name^="newitem['+ k +'"]');
							frm.focus();
							msgbox('error', v);
						}
					});
				}
			},
			error: function(data) {
				console.log(data.responseText);
				msgbox('error', 'Error on your request');
			},

		});
	}
}

form_delete = function(href)
{
	alertify.confirm("Are you sure to delete this record?", function() {
		location.href = global_config.base_url + href;
	});
}

$(document).ready(function() {
	$.fn.dataTable.ext.type.search.hiddenVal = function(data) {
	    return $('<div>').append(data).find('.hidden-val').text()
	}
	
    app.datagrid = $('.datagrid').DataTable({
    	'order': [],
		'columnDefs': [
			{
		      targets: [  2, 3, 5, 6, 7, 8],
		      orderable: false,
		      width: 90
			},
			{
				type: 'hiddenVal',
				targets: [0]
			}
		],
        'columns': [
        	{ "orderDataType": "dom-checkbox", type: 'string' },
            { "orderDataType": "dom-select", type: 'string' },
            { "orderDataType": "dom-text", type: 'string' },
            { "orderDataType": "dom-select", type: 'string' },
            { "orderDataType": "dom-select", type: 'string' },
            { "orderDataType": "dom-text", type: 'string' },
            { "orderDataType": "dom-text", type: 'string' },
            { "orderDataType": "dom-text", type: 'string' },
        ],
        'dom': 'tp',
        'scrollY': "100%",
        'scrollCollapse': true,
        'paging': false,
    });
    
    

    // initialize sort and filter
	app.filter_limit = 7; // override: number of columns only alowed to have filter
	app.col_skipped = [];
    sort_filter_init($('.datagrid thead th'));

    $('#btn-addgrid').on('click', function(e) {
    	var me = $(this).prop('disabled');
    	$(this).prop('disabled', !me);

    	app.entry_form();
    	//app.datagrid.row.add(app.input_fields).draw(false);
    	
    	// BEGIN: Insert to the top
        app.datagrid.row.add(app.input_fields).draw(false);
    	// END: Insert to the top
        
        
		// execute components
		$('.datepicker').datepicker();

		var $scrollBody = $(app.datagrid.table().node()).parent();
		$scrollBody.scrollTop($scrollBody.get(0).scrollHeight);

		// convert selection to more interactive
		$('select').select2();

		// attached browsing
		$('#new_customer_primary_fname').on('click', function(e) {
			var v = this;
	    	var param = {};
	    	param.origin = v;
	    	param.browsing = $(v).attr('data-browsing');
	    	param.targets = $(v).attr('data-targets');
	    	param.select = $(v).attr('data-select');
	    	if (param.browsing) {
	    		browsing_init(param);
	    	}
		});

		// focus
		$('#new_customer_primary_fname').focus();
		
	    // insert new record
	    $('input[name^="newitem"], select[name^="newitem"]').on('keypress', function(e) {
	    	if (e.keyCode == 13) {
				form_autosave(e.keyCode, this);
	    	}
	    });
    });
    
	// browsing
	$(document).on("browse_ok", function (evt) {
		var d = JSON.parse(store.get('browse_selected'));
		$('#new_customer_id').val(d.id);
		$('#new_customer_primary_fname').val(replace_null(d.primary_firstname + ' ' + d.primary_lastname));
		$('#new_customer_secondary_fname').val(replace_null(d.secondary_firstname + ' ' + d.secondary_lastname));
		$('table').find('tbody tr:last-child').css({ 'background-color':'#f0f8f0' });
	});

    $('#btn-printgrid').on('click', function() {
    	$.ajax({
    		url:global_config.base_url + "/api/reportdata_call",
    		method:"POST",
    		data: {
                    'report_name': 'action_item'
    		},
    		dataType: "json",
    		beforeSend: function() {
    			$('#loadingview-modal').modal('show');
    		},
    		complete: function(data) {
                    console.log('complete');
    		},
    		error: function(data) {
    			msgbox('error', 'Error on your request');
    			console.log(data.responseText);
    		}
    	})
    	.done(function(data) {
	    		if (data.status === 'success') {
                            var url = global_config.base_url + '/pdf/no_record.pdf';
                            if (data.json.report_url !== '') {
                                url = global_config.base_url + data.json.report_url;
                            }
                            $('#report_frame').attr('src', url);
                            $('#loadingview-modal').modal('hide');
                            $('#reportview-modal').on('shown.bs.modal', function () {
                                $(this).find('.modal-dialog').css({
                                	   'width':'80%',
                                       'height':'auto',
                                       'max-height':'100%'
                                        
                                });
                            });
                            $('#reportview-modal').modal('show');
	    		}
    	});
    });

    // update existing record
    $('input[name^="ActionItem"]').on('keypress', function(e) {
    	form_autoupdate(e.keyCode, this);
    });
    $('input[type="checkbox"][name^="ActionItem"]').on('click', function(e) {
    	e.prevenDefault;
    	form_autoupdate(13, this);
    });
    $('input[type="text"][name^="ActionItem"]').on('focusout', function(e) {
    	e.prevenDefault;
    	form_autoupdate(13, this);
    });
    $('select[name^="ActionItem"]').on('select2:select', function(e) {
    	form_autoupdate(13, e.currentTarget);
    });

    // track update action
    $.each($('input[name^="ActionItem"], select[name^="ActionItem"]'), function(k, v) {
    	var param = {};
    	param.origin = v;
    	param.browsing = $(v).attr('data-browsing');
    	param.targets = $(v).attr('data-targets');
    	param.select = $(v).attr('data-select');
    	// show browsing
    	if (param.browsing) {
	    	$(v).on('click', function(e) {
	    		browsing_init(param);
	    	});
    	}
    });

    // delete
	$('.btn-delete').on('click', function(e) {
		e.prevenDefault;
		var href = $(this).attr('href');
		form_delete(href);
	});

} );
