var AP = {
    dependents: function() {
        // Edit record
        $('input.Lfocus').on('focusout', function(e) {
               if($(this).hasClass('edited')) {
                   var form_id = $(this).attr('data-id');
                   $('#FormEdit_'+ form_id).submit();
               }
        });
        $('input.Lfocus').on('change', function(e) {
            $(this).addClass('edited');
        });
        $('select.Lfocus').on('select2:select', function(e) {
            var form_id = $(this).attr('data-id');
            $('#FormEdit_'+ form_id).submit();
        });
        
        // Add Button
        $('#btn-add-dependent').on('click', function(e) {
            e.preventDefault;
            
            $('.no-rec').remove();
            // Output
            $('#new-form').before(global_config.new_record);
            
            // New record event
            submit_now = function() {
                var param = $('input[name^="DependentNew"],select').serialize();
                $.post(global_config.current_url, param, function(data) {
                    msgbox(data.status, data.json);
                    location.reload();
                });
            }
            $('input.Lfocus-Add').on('focusout', function(e) {
                   if($(this).hasClass('added')) {
                       submit_now();
                   }
            });
            $('input.Lfocus-Add').on('keyup', function(e) {
                if(e.keyCode === 13) {
                   if($(this).hasClass('added')) {
                       submit_now();
                   }   
                }
            });
            $('input.Lfocus-Add').on('change', function(e) {
                $(this).addClass('added');
            });
            $('select.Lfocus-Add').on('select2:select', function(e) {
                e.preventDefault();
                submit_now();
            });
            
            skin_controls();
        });
    },
    current_coverages: function() {        
        // Edit record
    	$('select[name^="EditForm"]').on('select2:select', function(e) {
            e.prevenDefault;
            // Inline function
            submit_edit = function(that) {
                if ($(that).val() === 'newvalue') {
                    alertify.prompt('Enter one time use new value..', function(data) { 
                        var select = $(that);
                        var option = $('<option></option>').attr('selected', true).text(data).val(data);
                        option.appendTo(select);
                        select.trigger('change'); 

                        var param = that.serialize();
                        $.post(global_config.current_url, param, function(data) {
                            msgbox(data.status, data.json)
                        });
                    }, function() { 
                    });
                } else {
                    var param = that.serialize();
                    $.post(global_config.current_url, param, function(data) {
                        msgbox(data.status, data.json)
                    });
                }
            }

            var id = $(this).attr('id');
            if ((id.indexOf('Year') > -1)) {
            	return;
            }
            else if ((id.indexOf('Make') > -1)) {
            	return;
            }
            else if ((id.indexOf('Model') > -1)) {
            	return;
            } 
            else {
            	submit_edit($(this));
            }
        });

    	// Edit Form for Year, Make and Model
    	$('select[id^="Year"]').on("select2:select", function(e) {
    		var id = $(this).attr('data-id');
			var p = $(e)[0].params.data.text;
			id = parseInt(id) + 1;
			AP.current_coverage_edit_make(id, p);
			submit_edit($(this));
		});
    	$('select[id^="Make"]').on("select2:select", function(e) {
    		var id = $(this).attr('data-id');
			var p = $(e)[0].params.data.id;
			id = parseInt(id) + 1;
			AP.current_coverage_edit_model(id, p);
			submit_edit($(this));
		});
    	$('select[id^="Model"]').on("select2:select", function(e) {
			submit_edit($(this));
		});

    	
        // Show add form
        $('.btn-addpolicy').on('click', function(e) {
            e.preventDefault;
            var insurance_type = $(this).attr('data-id');
            var tbl            = $('#tbl_'+ insurance_type + ' > tbody:last-child');
            var ctr            = $('#tbl_'+ insurance_type).find('tr').length + 1;
            var newrec         = tpl_new_record[insurance_type];
            newrec             = newrec.replace(/xxxx/g, ctr);
            newrec             = newrec.replace(/yyyy/g, ctr);
            newrec             = newrec.replace(/zzzz/g, ctr);
            newrec             = newrec.replace(/TplForm/g, 'NewForm');
            tbl.append('<tr data-key="Row['+ insurance_type +']" class="newrow">'+ newrec + '</tr>');
            
            // Enable Button Save
            $('button[data-id^="'+ insurance_type +'"]').show();
            
            // Apply Select2 to all
            $('select[name^="NewForm"]').select2();
            
            // Carquery for Add
        	$('select[name="NewForm[Auto]['+ ctr +'][Year]"]').empty();
        	$('select[name="NewForm[Auto]['+ ctr +'][Year]"]').select2({
        		data: app.getyears
        	});
        	
        	// Events
        	$('select[name="NewForm[Auto]['+ ctr +'][Year]"]').on("select2:select", function(e) {
    			var p = $(e)[0].params.data.text;
    			AP.current_coverage_make(ctr, p);
    		});
        	$('select[name="NewForm[Auto]['+ ctr +'][Make]"]').on("select2:select", function(e) {
    			var p = $(e)[0].params.data.id;
    			AP.current_coverage_model(ctr, p);
            });
            
            // One time use value -- requested by Jim
        	$('select[name^="NewForm"]').on("select2:select", function(e) {
                e.preventDefault();
                var that = this;
                if ($(that).val() === 'newvalue') {
                    alertify.prompt('Enter one time use new value..', function(data) { 
                        var select = $(that);
                        var option = $('<option></option>').attr('selected', true).text(data).val(data);
                        option.appendTo(select);
                        select.trigger('change'); 
                    }, function() { 
                    });
                }
            });
        	
        });
        
        // Save add form
        $('.btn-savepolicy').on('click', function(e) {
            e.preventDefault;
            msgbox('success', 'Saving this new record...');
            var insurance_type = $(this).attr('data-id');
            var rows           = $('select[name*="['+ insurance_type +']"]');
            var param          = rows.serialize();
            $.post(global_config.base_url + '/api/currentcoverage_save', param, function(data) {
            	msgbox(data.status, data.json)
            	if (data.status === 'success') {
            		location.reload();
            	}
            });
        });
        
        $('.btn-delete').on('click', function(e) {
        	e.preventDefault;
        	var that = this;
        	alertify.confirm("Are you sure to delete this record?", function () {
            	var record_id = $(that).attr('record-id');
            	var row = $('select[record-id="'+ record_id +'"]');
            	
            	var data_id = [];
            	$.each(row, function(k, v) {
            		data_id.push($(v).attr('data-id'));
            	});
            	
            	var param = {
            			'data': data_id.join()
            	};
            	$.post(global_config.base_url + '/api/currentcoverage_delete', param, function(data) {
            		if (data.status === 'success') {
            			msgbox('success', data.json);
            			location.reload();
            		}
            	});
        	});
        });
        
    },
    current_coverage_year: function() {
        $.each($('select[id^="Year"]'), function(k, v) {
    		var a = $(v).val();
    		var b = $(v).attr('id');
    		c = b.split('_');
    		d = parseInt(c[1]);
    		
    		$yr = $('#Year_'+ d);
    		$yr.empty();
    		    		
    		$yr.select2({ data: app.getyears });
    		$yr.val($yr.attr('data-selected')).trigger('change');
        });
    },
    current_coverage_make: function(ctr, yr) {
        $.get(global_config.base_url + '/carquery/getmakes?year='+ yr, function(json) {
        	app.getmakes = json;
        	$('select[name="NewForm[Auto]['+ ctr +'][Make]"]').empty();
        	$('select[name="NewForm[Auto]['+ ctr +'][Make]"]').trigger('change');
        	$('select[name="NewForm[Auto]['+ ctr +'][Make]"]').select2({ data: app.getmakes });
        });
    },
    current_coverage_model: function(ctr, mk) {
        $.get(global_config.base_url + '/carquery/getmodels?make='+ mk, function(json) {
        	app.getmodels = json;
        	$('select[name="NewForm[Auto]['+ ctr +'][Model]"]').empty();
        	$('select[name="NewForm[Auto]['+ ctr +'][Model]"]').trigger('change');
        	$('select[name="NewForm[Auto]['+ ctr +'][Model]"]').select2({ data: app.getmodels });
        });
    },
    current_coverage_edit_make: function(ctr, yr) {
        $.get(global_config.base_url + '/carquery/getmakes?year='+ yr, function(json) {
        	app.getmakes = json;
        	$('#Make_'+ ctr).empty();
        	$('#Make_'+ ctr).trigger('change');
        	$('#Make_'+ ctr).select2({ data: app.getmakes });
        });
    },
    current_coverage_edit_model: function(ctr, mk) {
        $.get(global_config.base_url + '/carquery/getmodels?make='+ mk, function(json) {
        	app.getmodels = json;
        	$('#Model_'+ ctr).empty();
        	$('#Model_'+ ctr).trigger('change');
        	$('#Model_'+ ctr).select2({ data: app.getmodels });
        });
    },
    appointment: function() {
    	$('.my-send').hide();
    	$('input[name^="SendTo"]').change(function(e) {
    		if ($('input[name^="SendTo"]:checked').length === 0) {
    			$('.my-send').hide();
    			$('.my-next').show();
    		} else {
    			$('.my-send').show();
    			$('.my-next').hide();
    		}
    	});
    },
    jump_url: function(cval) {
        $.each(global_config.progress_nav, function(k, v) {
            if (v[0] === cval) {
                console.log(v[0]);

                var page_name = v[1];
                if (global_config.current_url.indexOf(page_name) > -1) {
                    return;
                }

                var a = global_config.current_url.split('/');
                var url = '/' + a[3] + '/' + page_name;
                location.href = url;

                return;
            }
        });
    },
    navigation_bar: function() {
        // custom progress for AP
        global_config.page_names = [
            'step_customer1',
            'step_customer2',
            'step_dependents',
            'step_current_coverages',
            'step_appointment',
            'step_send_na',
        ];
        var current_path = global_config.current_url;
        var _step1 = (100 / global_config.page_names.length);
        var _step2 = 100 / _step1;
        var _current_val = 0;
                
        global_config.progress_nav = [];
        for(i=1; i<=_step2 ;i++) {
            var nme = global_config.page_names[i-1];
            var nval = i * _step1;
            global_config.progress_nav.push([
                nval,
                nme
            ]);
            
            // current page position
            if (current_path.indexOf(nme) > -1) {
                _current_val = nval;
            }
        }
        
        var _top_progress_bar = $("#top-progress-bar");
        app.ticks = [];
        app.ticks_positions = [];
        app.progress_max = 100;
        for(ctr=1;ctr<=_step2;ctr++) {
        	app.ticks.push( (ctr * _step1)  );
        	app.ticks_positions.push( ((ctr * _step1) / 100) * 100  );
        }
        _top_progress_bar.slider({ 
                id: "slider12a", 
                min: _step1, 
                max: app.progress_max, 
                precision: 0,
                ticks: app.ticks,
                ticks_positions: [],
                value: _current_val, 
                step: _step1,
                handle: "custom",
                tooltip: "hide"
        }).on('change', function(aa) {
            AP.jump_url(aa.value.newValue);
        });
        _top_progress_bar.on('slide', function(cc) {
            AP.jump_url(cc.value);
        });
        top_bar_events();
        
    }
}

$(document).ready(function() {
		$('button[type="button"]').on('click', function(e) {
	            e.prevenDefault;
	            var url = $(this).attr('href');
	            if(url) {
	                location.href=url;
	            }
	
	            var id = $(this).attr('class');
	            if (id.indexOf('btn-action-item') > -1) {
	                dialogbox('Action Items', '/dialog/action_item', 'show');                
	            }
	            if (id.indexOf('btn-add-note') > -1) {
	                var dom_element = $(this).attr('data-dom');
	                if(dom_element) {
	                    global_config.notes_sections = dom_element;
	                    dialogbox('Add Note', '/dialog/add_note?url='+ global_config.current_url +'&dom_element='+dom_element, 'show');
	                } else {
	                    dialogbox('Add Note', '/dialog/add_note?url='+ global_config.current_url, 'show');
	                }
	                                
	            }
		});
        
        $(global_config.dlg).on('show.bs.modal', function() {
            $(this).find('.modal-dialog').css({
                   'width':'60%', //probably not needed
                   'height':'auto', //probably not needed 
                   'max-height':'100%'
            });
        });
        
        // query notes
        var param = {
            'page_url': global_config.current_url
        };
        $.post(global_config.base_url + '/api/notes', param, function(data) {
            if (data.status == 'success') {
              var dom_element='';
              var msg_note='<div style="margin-top:8px;margin-bottom:8px;"><strong>Notes:</strong><br>';
              $.each(data.json, function(k, v) { 
                if($(v.dom_element).find('strong').text()==="") {
                    $(v.dom_element).append(msg_note);
                }
                $(v.dom_element).append(v.msg_note +'<br>');
              });
              msg_note += '</div>';

            }
        });
        
        $('input[type="text"]').on('keyup focusout', function(e) {
        	if (e.keyCode === 9) {
        		return;
        	} else {
        		$(this).addClass('edited');
        	}
        	if ($(this).hasClass('edited')) {
        		$(this).val(toTitleCase($(this).val()));
        	}
        });
        
        // CarQuery initialize
        $.post(global_config.base_url + '/carquery/getyears', function(json) {
        	app.getyears = json;
        	AP.current_coverage_year();
        });

        
        // Agent Prep module - page script handler
        if (typeof global_config.page_name !== 'undefined') {
        	console.log(global_config.page_name);
        	switch(global_config.page_name) {
	        	case 'step_customer1':
	        		break;
	        	case 'step_dependents':
	        		AP.dependents();
	        		break;
	        	case 'step_current_coverages':
	        		AP.current_coverages();
	        		break;
	        	case 'step_appointment':
	        		AP.appointment();
	        		break;
        	}
        }
        AP.navigation_bar();
});

