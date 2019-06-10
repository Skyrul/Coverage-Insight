(function(a){(jQuery.browser=jQuery.browser||{}).mobile=/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))})(navigator.userAgent||navigator.vendor||window.opera);

top_bar_events = function() {
    // Global event for Progress Top Bar
    $('.slider.slider-horizontal').hover(function() {
        $('.slider-handle.custom').fadeIn();
    }, function() {
        $('.slider-handle.custom').fadeOut();
    });    
}

override_screen = function() {
    if (jQuery.browser.mobile) {
        $('.account-logo').addClass('img-thumbnail');
    } else {
        $('.account-logo').removeClass('img-thumbnail');
    }
}

goto_menu = function() {
    // Collapseable menu
	if ($('.goto').hasClass('goto-sub-collapse')) {
		$('.goto-menu').text('< Back');
		$('.goto-menu').click(function() {
			location.href = global_config.base_url + '/customer/listing';
        });
        
        // Disable context menu (Right click popup)
        $('.goto-sub-collapse').bind("contextmenu",function(e){
            var href = $(this).attr('href');
            window.open(href, '_blank');
            return false;
        });

        // Redirect when left-click
        $('.goto-sub-collapse').click(function(event) {
            var href = $(this).attr('href');
            location.href = href;
        });

		return;
	}
    
    $('.goto-sub').hide();
    $('.goto-menu').on('click', function() {
        $('.goto-sub').toggle();
        $('.goto-sub').on('click', function() {
            var href = $(this).attr('href');
            location.href = href;
        });
    });
}

openfeedback = function() {
    feedbackbox('Provide Feedback', '/feedback/create', 'show');
}

msgbox = function(notify, mtext) {
    if (typeof notify == "undefined") { return; }
    var msg = null;
    switch(notify) {
	    case 'success':
	        msg = "<br><span class='text-center'><h4>" + mtext + "</h4></span><br>";
	        alertify.success(msg);
	        //$('body').before('<div class="xhr-overlay xhr-lg xhr-success">'+ msg +'</div>');
	    	break;
	    case 'error':
	    	msg = "<br><span class='text-center'><h4>" + mtext + "</h4></span><br>";
	        alertify.error(msg);
	    	//$('body').before('<div class="xhr-overlay xhr-lg xhr-error">'+ msg +'</div>');
	    	break;
	    default:
	        msg = "<br><span class='text-center'><h4>" + mtext + "</h4></span><br>";
	        alertify.alert(msg);
	        //$('body').before('<div class="xhr-overlay xhr-lg xhr-default">'+ msg +'</div>');
	    	break;
    }
  	setTimeout(function() {
		$('.xhr-overlay').remove();
	}, 800);
}


dialogbox = function(title, url, visibility) {
    if (visibility === 'show') {
        $(global_config.dlg).find('.modal-body').empty();
        $(global_config.dlg).find('.modal-body').load(url);
        $(global_config.dlg).find('.modal-body').css({ 'background-color': 'white' });
        $(global_config.dlg).find('h4').text(title);
        $(global_config.dlg).modal(visibility);
    } else {
        $(global_config.dlg).modal(visibility);
    }
}

feedbackbox = function(title, url, visibility) {
    if (visibility === 'show') {
        $(global_config.dlg).find('.modal-body').empty();
        $(global_config.dlg).find('.modal-body').load(url);
        $(global_config.dlg).find('.modal-body').css({ 'background-color': 'white' });
        $(global_config.dlg).find('h4').text(title);
        $(global_config.dlg).on('shown.bs.modal', function () {
            $(global_config.dlg).find('.modal-dialog').css({
                   'width':'50%',
                   'height':'auto',
                   'max-height':'100%',
                   'padding': '20px'
            });
        });
        $(global_config.dlg).modal(visibility);
    } else {
        $(global_config.dlg).modal(visibility);
    }
}

isInArray = function(value, array) {
    return array.indexOf(value) > -1;
}

errorText = function(arr) {
    var str = '';
    $.each(arr, function(k, v) {
        str += arr[k] + "<br>";
    });
    return str;
}

toTitleCase = function(str)
{
    return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
}

skin_controls = function() {
    // Load controls
    $('input[type="text"]').addClass('form-control');
    $('input[type="password"]').addClass('form-control');

    /** Load global plugins **/
    // Datepicker
    $('.datepicker').datepicker();
    $('.datepicker').on('keypress', function() {
        return false;
    });

    // Timepicker
    $('.timepicker').timepicker();

    // Dropdown list
    $('select').select2();

    // Phone mask
    $('.phone-mask').inputmask({
        "mask": "(999)-999-9999"
    });

    // Draggable element
    var dragable = document.getElementsByClassName('dragable');
    if (dragable) {
        dragElement(dragable);
    }
    
}

showReport = function (url)
{
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

popWindow = function(url, windowName, param) {
    var winsize;
    var newwindow;
    if (typeof param !== 'undefined') {
        winsize = 'height='+ param.h +',width='+param.w;
    }
    newwindow = window.open(url, windowName, winsize);
    if (window.focus) { newwindow.focus(); }
    return false;
}

validateEmail = function(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

dragElement = function(elmnt) {
    var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
    if (document.getElementById(elmnt.id + "header")) {
      /* if present, the header is where you move the DIV from:*/
      document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
    } else {
      /* otherwise, move the DIV from anywhere inside the DIV:*/
      elmnt.onmousedown = dragMouseDown;
    }
  
    function dragMouseDown(e) {
      e = e || window.event;
      e.preventDefault();
      // get the mouse cursor position at startup:
      pos3 = e.clientX;
      pos4 = e.clientY;
      document.onmouseup = closeDragElement;
      // call a function whenever the cursor moves:
      document.onmousemove = elementDrag;
    }
  
    function elementDrag(e) {
      e = e || window.event;
      e.preventDefault();
      // calculate the new cursor position:
      pos1 = pos3 - e.clientX;
      pos2 = pos4 - e.clientY;
      pos3 = e.clientX;
      pos4 = e.clientY;
      // set the element's new position:
      elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
      elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
    }
  
    function closeDragElement() {
      /* stop moving when mouse button is released:*/
      document.onmouseup = null;
      document.onmousemove = null;
    }
  }

/* jQuery Extension */
/* Create an array with the values of all the input boxes in a column */
$.fn.dataTable.ext.order['dom-text'] = function(settings, col) {
    return this.api().column(col, {
        order: 'index'
    }).nodes().map(function(td, i) {
        return $('input', td).val();
    });
}

/* Create an array with the values of all the input boxes in a column, parsed as numbers */
$.fn.dataTable.ext.order['dom-text-numeric'] = function(settings, col) {
    return this.api().column(col, {
        order: 'index'
    }).nodes().map(function(td, i) {
        return $('input', td).val() * 1;
    });
}

/* Create an array with the values of all the select options in a column */
$.fn.dataTable.ext.order['dom-select'] = function(settings, col) {
    return this.api().column(col, {
        order: 'index'
    }).nodes().map(function(td, i) {
        return $('select', td).val();
    });
}

/* Create an array with the values of all the checkboxes in a column */
$.fn.dataTable.ext.order['dom-checkbox'] = function(settings, col) {
//	debugger;
    return this.api().column(col, {
        order: 'index'
    }).nodes().map(function(td, i) {
        return $('input', td).prop('checked') ? '1' : '0';
    });
}

// Top insert datatable
$.fn.dataTable.Api.register('row.addByPos()', function(data, index) {     
    var currentPage = this.page();

    //insert the row  
    this.row.add(data);

    //move added row to desired index
    var rowCount = this.data().length-1,
        insertedRow = this.row(rowCount).data(),
        tempRow;

    for (var i=rowCount;i>=index;i--) {
        tempRow = this.row(i-1).data();
        this.row(i).data(tempRow);
        this.row(i-1).data(insertedRow);
    }     

    //refresh the current page
    this.page(currentPage).draw(false);
});

/* Main */
if (window.jQuery) {
    $(document).ready(function() {
        goto_menu();

        // Elements that have Events
        $('.account-logo').on('click', function() {
            location.href = global_config.base_url;
        });

        $('.card').on('click', function(e) {
            var url = $(this).attr('href');
            if (url) {
                location.href = url;
            }
        });

        window.onload = function() {
            override_screen();
            skin_controls();
        };

        window.onresize = function() {
            override_screen();
            location.reload();
        }

    });
}
