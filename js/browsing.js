/*
 @company  Engagex
 @author   joven barola
 
 @name     browsing.js
 @description
 popup-form sort and filter component
 */
function position_browsing_form(t, target)
{
    $(target).css("position", "absolute");
    $(target).css("top", Math.max(0, (($(window).height() - $(target).outerHeight()) / 2) +
            $(window).scrollTop()) + "px");
    $(target).css("left", Math.max(0, (($(window).width() - $(target).outerWidth()) / 2) +
            $(window).scrollLeft()) + "px");
}

close_browse_form = function ()
{
    $('.popup-browsing-filter').remove();
    $.event.trigger({
        type: "browse_ok",
        message: "done browsing",
        time: new Date()
    });
}

show_browse_form = function (data)
{
    var sb = new StringBuilder();
    sb.clear();
    sb.append('<div class="popup-browsing-filter">');
    sb.append('<h1 class="text-center" style="background-color: #94003c;color: white;padding: 6px;margin-top: 0px;">');
    sb.append('Browse ' + toTitleCase(app.browse_name));
    sb.append('</h1>');
    sb.append('<button type="button" class="btn btn-primary pull-left" onclick="close_browse_form()">');
    sb.append('<i class="fa fa-close"></i> Exit');
    sb.append('</button>');
    sb.append('<table class="browsing-table table table-bordered table-hover">');
    sb.append('<thead>');
    
    // Header
    ctr = 1;
    $.each(data.json, function (k, v) {
        if (ctr === 1) {
            sb.append('<tr>');
            $.each(v, function (k1, v1) {
            	var column_only = app.browse_select.split(',');
            	if ($.inArray(k1, column_only) !== -1) {
            		k1 = k1.replace('_', ' ');
            		k1 = toTitleCase(k1);
            		sb.append('<th>' + k1 + '</th>');
            	}
            });
            sb.append('</tr>');
        }
        ctr++;
    });
    sb.append('</thead>');

    // Body
    sb.append('<tbody>');
    $.each(data.json, function (k, v) {
        sb.append("<tr  data-json='" + JSON.stringify(v) + "'>");
        $.each(v, function (k1, v1) {
        	var column_only = app.browse_select.split(',');
        	if ($.inArray(k1, column_only) !== -1) {
        		sb.append('<td>' + ((v1) ? v1 : '') + '</td>');
        	}
        });
        sb.append('</tr>');
    });
    sb.append('<tbody>');
    sb.append('</table>');
    sb.append('</div>');



    $('body').append(sb.toString());
    $('.browsing-table').dataTable({'dom': 'f'});
    $('.popup-browsing-filter').show();

    // events
    $('.browsing-table tr').on('click', function (e) {
        e.preventDefault;
        if (window.store) {
            store.set('browse_selected', $(this).attr('data-json'));
            store.set('browse_ok', 1);
            close_browse_form();
        }
    });
};

browsing_init = function (param) {
    if (typeof app === 'undefined') {
        alert('Browsing component doesnt detect required global settings');
        return false;
    }
    app.browse_origin = param.origin;
    app.browse_name = param.browsing;
    app.browse_targets = param.targets;
    app.browse_select = param.select;

    $.post(global_config.base_url + '/browse/module?id=' + app.browse_name, function (data) {
        show_browse_form(data);
        position_browsing_form(app.browse_origin, '.popup-browsing-filter');
    });
}