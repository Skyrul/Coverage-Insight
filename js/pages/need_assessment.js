var NA = {
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
            e.preventDefault();
            
            $('#new-form').show();
            
            // New record event
            submit_now = function() {
                $('#DependentNewForm').submit();
            }
            $('input.Lfocus-Add').on('focusout', function(e) {
                   if($(this).hasClass('added')) {
                       $('#NewForm').submit();
                   }
            });
            $('input.Lfocus-Add').on('keyup', function(e) {
                if(e.keyCode === 13) {
                   if($(this).hasClass('added')) {
                       $('#NewForm').submit();
                   }   
                }
            });
            $('input.Lfocus-Add').on('change', function(e) {
                $(this).addClass('added');
            });
            $('select.Lfocus-Add').on('select2:select', function(e) {
                $('#NewForm').submit();
            });
            
            skin_controls();
        });
    },
    questions: function() {
        $('input[type="checkbox"]').on('click', function(e) {
            console.log(e);
            $('input[type="checkbox"]').prop('checked', false);
            $(e.currentTarget).prop('checked', true);
        });
    },
    policies_in_place: function() {
        $('.btn-add-policy').on('click', function(e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            $('#new-form'+id).show();
            skin_controls();
            
            // CarQuery initialize
            $.post(global_config.base_url + '/carquery/getyears', function(json) {
            	app.getyears = json;
            	NA.current_coverage_year();
            	// Add New Record - Related to CarQuery
            	$('select[name="NewForm[Add][Year]"]').empty();
            	$('select[name="NewForm[Add][Year]"]').select2({
            		data: app.getyears
            	});
            	$('select[name="NewForm[Add][Year]"]').on("select2:select", function(e) {
        			var p = $(e)[0].params.data.text;
        			NA.current_coverage_make(ctr, p);
        		});
            	$('select[name="NewForm[Add][Make]"]').on("select2:select", function(e) {
        			var p = $(e)[0].params.data.id;
        			NA.current_coverage_model(ctr, p);
        		});
            });
        });
        
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
        
        // New record
        $('input.Lfocus-Add').on('focusout', function(e) {
            e.preventDefault();
            if($(this).hasClass('added')) {
                $('#NewForm'+$(this).attr('data-id')).submit();
            }
        });
        $('input.Lfocus-Add').on('keyup', function(e) {
            e.preventDefault();
            if(e.keyCode === 13) {
               if($(this).hasClass('added')) {
                   $('#NewForm'+$(this).attr('data-id')).submit();
               }   
            }
        });
        $('input.Lfocus-Add').on('change', function(e) {
            $(this).addClass('added');
        });
        $('select.Lfocus-Add').on('select2:select', function(e) {
            if ($('input.Lfocus-Add').val()!='') {
               e.preventDefault();
               $('#NewForm'+$(this).attr('data-id')).submit();   
            }
        });
        
        
    },
    current_coverage_year: function() {
        $.each($('select[name*="Year"]'), function(k, v) {
    		var a = $(v).val();
    		var b = $(v).attr('name');
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
        	$('select[name="NewForm[Add][Make]"]').empty();
        	$('select[name="NewForm[Add][Make]"]').trigger('change');
        	$('select[name="NewForm[Add][Make]"]').select2({ data: app.getmakes });
        });
    },
    current_coverage_model: function(ctr, mk) {
        $.get(global_config.base_url + '/carquery/getmodels?make='+ mk, function(json) {
        	app.getmodels = json;
        	$('select[name="NewForm[Add][Model]"]').empty();
        	$('select[name="NewForm[Add][Model]"]').trigger('change');
        	$('select[name="NewForm[Add][Model]"]').select2({ data: app.getmodels });
        });
    },
    top_concerns: function() {
        $('input[type="checkbox"]').on('click', function(e) {
            console.log(e);
            var ctr = $('input[type="checkbox"]:checked').length;
            if (ctr > 3) {
                msgbox('error', 'Only 3 selections are allowed');
                return false;
            } else {
                var d = $(e.currentTarget).is(':checked');
                $(e.currentTarget).prop('checked', d);
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
        // custom progress for NA
        // global_config.page_names = [
        //     'step_instructions',
        //     'step_customer1',
        //     'step_customer2',
        //     'step_dependents',
        //     'step_policies_in_place',
        //     'step_questions',
        //     'step_top_concerns',
        //     'step_life_changes',
        //     'step_long_term_goals',
        //     'step_appointment',
        // ];
        var current_path = global_config.current_url;
        var _step1 = (100 / global_config.page_names.length);
        var _step2 = 100 / _step1;
        var _current_val = 0;

        _step1 = Math.round(_step1, 0);

        global_config.progress_nav = [];
        for(i=1; i<=_step2 ;i++) {
            var nme = global_config.page_names[i-1];
            var nval = i * _step1;
            nval = Math.round(nval, 0);
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
            nval = 0;
            nval = Math.round((ctr * _step1), 0);
        	app.ticks.push( nval );
        	app.ticks_positions.push( (nval / 100) * 100  );
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
            console.log(aa);
            NA.jump_url(aa.value.newValue);
        });
        _top_progress_bar.on('slide', function(cc) {
            NA.jump_url(cc.value);
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
                
        
        // needs assessment module - page script handler
        if (global_config.page_name) {
            if (global_config.page_name==='step_dependents') {
                NA.dependents();
            }
            if (global_config.page_name==='step_questions') {
                NA.questions();
            }
            if (global_config.page_name==='step_policies_in_place') {
                NA.policies_in_place();   
            }
            if (global_config.page_name==='step_top_concerns') {
                NA.top_concerns();
            }     
        }
        
        NA.navigation_bar();
        
        if (typeof global_config.disable_input !== "undefined") {
            $('.btn-remove').prop('disabled', true);
            $('.btn-add-policy').hide();
            $('#btn-add-dependent').hide();
            $('input[type="text"]').prop('readonly', true);
            $('input[type="checkbox"]').prop('disabled', true);
            $('textarea').prop('disabled', true);
            $('select').select2("enable",false)
            if ($('[name="yt1"]').val() === "Close") {
                $('[name="yt1"]').hide();
            }
            $('.page-sub-label').append('&nbsp;<span style="color: white;background-color: orange;padding: 2px;padding-left: 10px;padding-right: 10px;font-size: 12px;">READ-ONLY</span>');
        }
});

