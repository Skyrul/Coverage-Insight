var CIR = {
    customer: function() {
        if (hlt_data.length > 0) {
            CIR.compare(hlt_data["AP:Customer"][0], hlt_data["NA:Customer"][0]);
        }
    },
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
            
            $('#no-record-status').hide();
            
            $('#new-form').show();
            
            // New record event
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
        
        CIR.compareById(hlt_data["AP:Dependent"], hlt_data["NA:Dependent"], 'dependent_name');
    },
    educations: function() {
    	$('.chk-resource').change(function(e) {
    		e.preventDefault();

    		var insurance_type = $(this).attr('data-itype');
    		var param = $('.chk-resource').serialize();
    		$.post(global_config.base_url + '/cir/save_education_resource?insurance_type='+insurance_type, param, function(data) {
    			msgbox(data.status, data.json);
    		});
    	});
    },
    current_coverage: function() {
        CIR.compareById(hlt_data["AP:CurrentCoverage"][0], hlt_data["NA:CurrentCoverage"][0]);
    },
    questions: function() {
        $('input[type="checkbox"]').on('click', function(e) {
            console.log(e);
            $('input[type="checkbox"]').prop('checked', false);
            $(e.currentTarget).prop('checked', true);
        });
    },
    update_referrals: function() {
        console.log('update referrals');
        var action = false;
        var id = 0;
        $.each($('[name^="ReferralEdit"]'), function(k, v) {
            if ($(v).hasClass('edited')) {
                action = true;
                id = $(v).attr('data-id');
                return;
            }
        });
        if (action) {
            $('#EditForm_'+ id).submit();   
        }
    },
    referrals: function() {
      $('[name^="ReferralNew"]').on('change', function(e) {
            e.preventDefault();
            $('.btn-save-referral').show();
      });
      $('.btn-save-referral').on('click', function(e){
        e.preventDefault();
        var action = false;
        var a = $('[name="ReferralNew[refer_name]"]').val();
        var b = $('[name="ReferralNew[refer_email]"]').val();
        if (a == '' && b == '') {
            alertify.error('Input Required (Name, Email)');
        }
        else if (!validateEmail(b)) {
            alertify.error('Invalid email address');
        } 
        else {
            action = true;
        }
        if (action) {
            $('#NewForm').submit();   
        }
      });

      $('.btn-update-referral').on('click', function() {
        CIR.update_referrals();
      });
      $('[name^="ReferralEdit"]').on('keypress', function(e) {
          $('.btn-update-referral').show();
          $(this).addClass('edited');
          if (e.keyCode === 13) {
            CIR.update_referrals();
          }
      });
      
      $('.btn-add-referral').on('click', function(e) {
          $('.tr-referral').show();
      });
      
      $('.btn-remove').on('click', function(e) {
          e.preventDefault;
          var href=$(this).attr('data-href');
          alertify.confirm('Do you want to delete this item?', function() {
              location.href=href;
          });
      });
      
      $('.btn-send-credit').on('click', function(e) {
        e.preventDefault();
        var param = {
            refer_email: $(this).attr('data-email'),
            refer_id: $(this).attr('data-id')
        };
        $.post(global_config.base_url + "/dialog/sendcredit", param, function(html) {
            $('#frm').remove();
            $('body').append(html);
            setTimeout(function() {
                $('#frm').modal('show');
            }, 400);
        });
      });

      $('.btn-referral-edit-gc').on('click', function(e) {
          e.preventDefault();
          alert(0);
        //   $.post(global_config.base_url + "/dialog/sendcredit", param, function(data) {
        //   });
      });


    },
    compare: function(arr1, arr2) {
        $.each(arr1, function(k, v) {
            $.each(arr2, function(k1, v1) {
                console.log(k+' === '+k1, k === k1);
                if (k === k1) {
                    if (v !== v1) {
                        CIR.highlight(k);
                    }
                }
            });
        });  
    },
    compareById: function(arr1, arr2, key) {
        $.each(arr1, function(k, v) {
            $.each(arr2, function(k1, v1) {
                
                // Check if Edited
                var inpt = $('input[data-id="'+ v.id +'"]');
                if (inpt.length > 0) {
                    if (v.id === v1['id'] && inpt.val() !== v1[key]) {
                        CIR.highlightById(v1);
                    }                    
                }
                // Check if deleted
                if (inpt.length === 0) {
                    if ($('#delmsg'+ key).length === 0) {
                        CIR.showStatus('#NewForm', '<span id="delmsg'+ key +'" style="color:red">* ' + v[key] + ' is deleted</span>');
                    }
                }
            });
        });
        
        function is_exist(search, key)
        {
            var result = false;
            $.each(arr1, function(k, v) {
                if (search === v[key]) {
                    result = true;
                    return;
                }
            });
            return result;
        }
        
        $.each(arr2, function(k, v) {
            if (is_exist(v.id, 'id') === false) {
               CIR.highlightById(v); 
            }
        });
    },
    highlight: function(field_name) {
        $('input[name*="'+ field_name +'"]').css({'background-color':'#f7d570', 'color':'red'});
    },
    highlightById: function(field) {
        var fld = $('input[data-id="'+ field.id +'"]');
        fld.css({'background-color':'#f7d570', 'color':'red'});
    },
    showStatus: function(target, status_text) {
        $(target).after(status_text);
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
        // custom progress for CIR
        // global_config.page_names = []; // wil be generated by controller

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
            console.log(aa);
            CIR.jump_url(aa.value.newValue);
        });
        _top_progress_bar.on('slide', function(cc) {
            CIR.jump_url(cc.value);
        });
        top_bar_events();
    }
}

print_report = function(id) {
    showReport(global_config.base_url + "/reports/renderpdf?report_name=cir&report_type=basic&customer_id="+ id);
    return false;
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
	            if (id.indexOf('btn-goals-concerns') > -1) {                                
	                dialogbox('Goals & Concerns', '/dialog/goals_concerns', 'show');
	            }
		});
        
        $(global_config.dlg).on('show.bs.modal', function() {
            $(this).find('.modal-dialog').css({
                   'width':'50%', //probably not needed
                   'height':'auto', //probably not needed 
                   'max-height':'100%'
            });
        });
        
        // query notes
        var page_url = global_config.current_url.replace('cir', 'agentprep');
        var param = {
            'page_url': page_url
        };
        $.post(global_config.base_url + '/api/notes', param, function(data) {
            if (data.status == 'success') {
              var dom_element='.page-note';
              var msg_note='<div style="margin-top:8px;margin-bottom:8px;"><strong>Notes:</strong><br>';
              $.each(data.json, function(k, v) { 
                if($(dom_element).find('strong').text()==="") {
                    $(dom_element).append(msg_note);
                }
                $(dom_element).append(v.msg_note +'<br>');
              });
              msg_note += '</div>';

            }
        });
                
        
        // customer insurance review module - page script handler
        if (global_config.page_name) 
        {
            if (typeof hlt_data === 'undefined') {
                hlt_data = [];
            }
            CIR.navigation_bar();
            console.log(global_config.page_name);
            switch(global_config.page_name) {
                case 'step_customer1':
                case 'step_customer2':
                    CIR.customer();
                    break;
                case 'step_educations':
                    CIR.educations();
                    break;
                case 'step_dependents':
                    CIR.dependents();
                    break;
                case 'step_questions':
                    CIR.questions();
                    break;
                case 'step_referrals':
                    CIR.referrals();
                    break;
            }

            // Create remote support button
            if (typeof global_config.remotesupport !== "undefined") {
                $('body').append('<a href="'+ global_config.remotesupport +'" target="_blank" class="float"><i class="fa fa-heartbeat fa-2x my-float"></i> Remote Support</a>');
            }
            
        }
        
});