/*
@company  Engagex
@author   joven barola

@name     sort_filter.js
@description
    popup-form sort and filter component
*/
function position_form(t, target)
{
	var pos=$(t).offset();
	var h=$(t).height();
	var w=$(t).width();

	$(target).css({ left: pos.left + w + -14, top: pos.top + h + 4 });
}

sort_column = function(col_id, order)
{
	var sortby = (order === 1) ? "asc" : "desc";
	app.datagrid.column(col_id).order(sortby).draw();
}

search_text = function(col_id, text)
{
	if (text == null) {
		text = '';
	}
	app.datagrid.columns(col_id).search(text).draw();
}

search_checkbox = function(col_id)
{
    var selected = [];
    $.each($('.filter-checkbox'), function () {
         if ($(this).is(":checked")) {
             selected.push('(?=.*' + $(this).val() + ')');
         }
    });
    
    app.datagrid.columns(col_id).search(selected.join('|'), true, false, false).draw();
}

check_checkbox = function(col_id, k)
{
    var checked = $('#checkbox-'+ k).is(':checked');
    $('#checkbox-'+ k).prop('checked', !checked);
    $('#select-all').prop('checked', false);
    search_checkbox(col_id);
}

checkit = function(col_id, action)
{
    if (action) {
        var checkall = (action==0) ? true : false;
        $('[id^="checkbox-"]').prop('checked', !checkall);
    } else {
        var checked = $('#select-all').is(':checked');
        $('#select-all').prop('checked', !checked);
        $('[id^="checkbox-"]').prop('checked', !checked);
    }
    search_checkbox(col_id);

}

close_filter_form = function()
{
	$('.popup-sort-filter').remove();
}

show_filter_form = function(e)
{
  	e.preventDefault;
	  var sb = new StringBuilder();
  	var col_id = $(this).attr('col-id');

    app.datagrid.columns(col_id).every(function() {
    	var data = this.data().unique();  // get distinct data rows
    	
    	sb.append('<div class="popup-sort-filter col-xs-2" style="display:none;">');
    	sb.append('<button class="btn btn-primary btn-sm" style="width: 75px; margin-left: 100px;" onclick="close_filter_form()">OK</button><br>');
    	sb.append('<div style="border-bottom: 1px solid gray;">Sort</div>');
    	sb.append('&nbsp;&nbsp;<a href="#!" onclick="sort_column('+ col_id +', 1)">A to Z</a><br>');
    	sb.append('&nbsp;&nbsp;<a href="#!" onclick="sort_column('+ col_id +', 2)">Z to A</a><br><br>');
    	sb.append('<div style="border-bottom: 1px solid gray;color: #666666;">Filter</div>');
    	sb.append('<div style="height: 99px; overflow-y: auto;border-left:1px dotted gray;border-right:1px dotted gray;padding:2px;">');
        sb.append('<input type="checkbox" class="filter-checkbox" id="select-all" onclick="checkit('+ col_id +',null)" value="" /><a href="#!" onclick="checkit('+ col_id +',null)">(Select All)</a><br>');
        
        // get unique values
        app.unique_vals = [];
    	$.each(data, function(k, v) {
    		  if (v.indexOf('span') !== -1 && v.indexOf('input') !== -1) {
    			  var s = v.split("\n");
    			  v = $(s[0]).text();
		          if (v !== ' ') {		          
			          if ($.inArray(v, app.unique_vals) === -1) {
			        	  app.unique_vals.push(v);
			          }
		          }
    		  }
    		  else if (v.indexOf('input') !== -1 || v.indexOf('select') !== -1) {
		          v = $(v).val();
		          if (v !== ' ') {		          
			          if ($.inArray(v, app.unique_vals) === -1) {
			        	  app.unique_vals.push(v);
			          }
		          }
		      } 
		      else if (v.indexOf('div') !== -1) {
		    	  v = $(v).text();
		    	  if (v !== '') {
		    		  app.unique_vals.push(v);  
		    	  }
		      }
		      else {
		    	  app.unique_vals.push(v);
		      }
    	});
    	// show unique values
    	$.each(app.unique_vals, function(k, v) {
    			var cv = '';
    			if (v === '1') {
    				cv = 'Yes';
    			} 
    			else if (v === '0') {
    				cv = 'No';
    			}
    			else {
    				cv = v;
    			}
    			sb.append('<input type="checkbox" class="filter-checkbox" id="checkbox-'+ k +'" onclick="search_checkbox('+ col_id +')" value="'+ v +'"><a href="#!" onclick="check_checkbox('+ col_id +','+ k +')">'+ cv +'</a><br>');
    	});
    	
    	sb.append('</div>');
        //sb.append('<a href="#!" onclick="checkit('+ col_id +',0)">Uncheck All</a> ');
    	sb.append('<br>');
    	sb.append('<input style="width: 174px !important;" type="text" placeholder="Filter Text" onkeyup="search_text('+ col_id+', $(this).val())">');
    	sb.append('<br><br><a style="cursor: pointer; margin-left: 100px;" onclick="search_text('+ col_id +', null)">[Reset]</a>');
    	sb.append('</div>');
    });

    $('body').append(sb.toString());
    if ( $('.popup-sort-filter').is(':visible') ) {
    	$('.popup-sort-filter').remove();
    } else {
    	position_form(this, '.popup-sort-filter');
    	$('.popup-sort-filter').show();	
    }    
};

sort_filter_init = function(dom) {
    if (typeof app === 'undefined') {
        alert('Sort and Filter component doesnt detect required global settings');
        return false;
    }

    dom.each(function() {
          var title = $(this).text();
          var filter_icon = '';
          if (app.col_ctr <= app.filter_limit) {
              if (!isInArray(app.col_ctr, app.col_skipped)) {
                filter_icon = '<span id="filter_'+ app.col_ctr +'" col-id="'+ app.col_ctr +'" class="filter-icon pull-left" style="color: #666666;"><i class="fa fa-caret-down"></i></span>';
              }
          }
          $(this).html('<div>'+ filter_icon +'&nbsp;<i>'+ title +'</i></div>');
          $('#filter_'+ app.col_ctr).on('click', show_filter_form);

          app.col_ctr++;
    });
}